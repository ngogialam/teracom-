<?php

namespace App\Services;

use App\Http\Controllers\BaseController;
use App\Models\FileAttachment;
use App\Repositories\ProcessRepositoryInterface;
use App\Repositories\TaskRepositoryInterface;
use App\Repositories\TicketRequestRepositoryInterface;
use App\Repositories\ProcessStepRepositoryInterface;
use App\Repositories\TaskObjectRepositoryInterface;
use App\Services\TicketRequestService;
use App\Models\Task;
use App\Models\ProcessStep;
use App\Models\TicketRequest;
use App\Repositories\FileAttachmentRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TaskService
{
    public function __construct(
        protected TaskRepositoryInterface $taskRepository,
        protected ProcessRepositoryInterface $processRepository,
        protected TicketRequestRepositoryInterface $tickRepository,
        protected ProcessStepRepositoryInterface $processStepRepository,
        protected TicketRequestService $ticketRequestService,
        protected TaskObjectRepositoryInterface $taskObjectRepository,
        protected FileAttachmentRepositoryInterface $attachmentRepository
    ) {
        //
    }

    /**
     * get all tasks
     *
     * @param array $params
     * @return array
     */
    public function all(array $params): array
    {
        if (empty($params['assignee_id'])) {
            return ["data" => []];
        }
        $limit = $params['limit'] ?? BaseController::DEFAULT_LIMIT;
        $page = $params['page'] ?? BaseController::DEFAULT_PAGE;
        $processRepository = $this->processRepository;
        $taskRepository = $this->taskRepository;
        $processIds = [];
        $taskIds = [];
        $isCheck = true;
        $taskRepository = $taskRepository->with(['tickectRequest', 'taskObject'])
            ->orderBy('id', 'desc')
            ->where('assignee_id', $params['assignee_id']);
        $taskRepository = $this->addFilterByParams($taskRepository, $params, true, $isCheck);

        $tasks = $taskRepository->get();
        foreach ($tasks as $task) {
            if (
                !empty($params['nameProcessOrCodeTicket'])
                && $task['tickectRequest']['code'] == $params['nameProcessOrCodeTicket']
            ) {
                $isCheck = false;
            }
            if (!empty($params['object_id']) && !empty($task['taskObject'])) {
                foreach ($task['taskObject'] as $taskObject) {
                    if ($taskObject->object_id == $params['object_id']) {
                        array_push($taskIds, $task->id);
                        array_push($processIds, $task['process']['id']);
                    }
                }
                continue;
            }
            array_push($taskIds, $task->id);
            array_push($processIds, $task['process']['id']);
        }

        $processRepository = $processRepository->with('tasks')->whereIn('id', array_unique($processIds));
        $processRepository = $this->addFilterByParams($processRepository, $params, false, $isCheck);
        $totalItem = $processRepository->count();
        $process = $processRepository->skip(($page - 1) * $limit)
            ->take($limit)
            ->get();

        $process = $this->getProcessWithTask($process, $taskIds);
        return [
            'list'      => $process,
            'limit'     => $limit,
            'page'      => $page,
            'totalItem' => $totalItem
        ];
    }

    public function create(array $params): array
    {
        return $this->taskRepository->create($params);
    }

    /**
     * update task information
     *
     * @param array $params
     * @param int $id
     * @return array
     */
    public function update(array $params, int $id): array
    {
        $task = $this->taskRepository->with(['tickectRequest', 'processStep'])->find($id);
        if (!empty($params['file_attachment_ids'])) {
            $this->attachment($task['data']['id'], $params['file_attachment_ids']);
        }
        if ($task['data']['status'] != $params['status'] && $params['status'] != Task::STATUS_ACTIVE) {
            if ($task['data']['processStep']['step_type'] == ProcessStep::STEP_TYPE_FINISH) {
                $ticket = $this->tickRepository->update(['complete' => 2], $task['data']['tickectRequest']['id']);
                if ($ticket['data']['ticket_type'] == TicketRequest::TICKET_TYPE_AUTO) {
                    $taskAuto = $this->taskRepository->findWhere(['auto_ticket_req_id' => $ticket['data']['id']]);
                    $this->taskRepository->update(['status' => Task::STATUS_COMPLETE], $taskAuto['data'][0]['id']);
                    $this->createTask($taskAuto['data'][0]);
                }
            } else {
                $this->createTask($task['data']);
            }
        }
        return $this->taskRepository->update($params, $id);
    }

    /**
     * @param integer $id
     * @return array
     */
    public function show(int $id): array
    {
        return $this->taskRepository->with(['tickectRequest', 'processStep'])->find($id);
    }

    /**
     * add attachment file to task
     *
     * @param integer $taskId
     * @param array $attachmentIds
     * @return void
     */
    public function attachment(int $taskId, array $attachmentIds): void
    {
        foreach ($attachmentIds as $attachmentId) {
            $this->attachmentRepository->update([
                'target_id' => $taskId,
                'target_type' => FileAttachment::TARGET_TYPE_TASK
            ], $attachmentId);
        }
    }

    /**
     * Get attachment file by task id
     *
     * @param integer $id
     * @return array
     */
    public function getFileAttachment(int $id): array
    {
        $processAttachments = $this->attachmentRepository
            ->findwhere(['target_id' => $id, 'target_type' => FileAttachment::TARGET_TYPE_TASK]);
        return $processAttachments['data'];
    }

    /**
     * delete task by id
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->taskRepository->delete($id);
    }

    /**
     * create new task by normal or auto
     *
     * @param array $task
     * @return void
     */
    private function createTask(array $task): void
    {
        $taskType = Task::TASK_NORMAL;
        $automaticTicket = null;
        $processStep = $this->processStepRepository->findWhere([
            'process_id' => $task['processStep']['process_id'],
            'step_order' => $task['processStep']['step_order'] + ProcessStep::JUMP_STEP
        ]);
        if (count($processStep['data']) == 0) {
            return;
        }
        if (!empty($processStep['data'][0]['child_process_id'])) {
            $taskType = Task::TASK_AUTO;
            $automaticTicket = $this->createAutomaticTicket($processStep['data'][0]['child_process_id']);
        }
        $slaQuantity = $processStep['data'][0]['sla_quantity'];
        $slaUnit = $processStep['data'][0]['sla_unit'];
        $expectedCompletedTime = convertSla($slaQuantity, $slaUnit, Carbon::now('Asia/Ho_Chi_Minh'));
        $ticketCode = $task['tickectRequest']['code'];
        $stepOrder = $task['processStep']['step_order'];
        $nextStepOrder = $stepOrder + ProcessStep::JUMP_STEP;
        $code = $ticketCode . '_' . Task::STEP_SHORT_NAME . $nextStepOrder;
        $this->taskRepository->create([
            'code' => $code,
            'ticket_req_id' => $task['tickectRequest']['id'],
            'step_id' => $processStep['data'][0]['id'],
            'task_type' => $taskType,
            'assignee_id' => 1,
            'department_id' => $task['tickectRequest']['department_id'],
            'action' => $task['tickectRequest']['ticket_action'],
            'approval_status' => $task['tickectRequest']['approval_status'],
            'rollback_step_id' => $processStep['data'][0]['id'],
            'rollback_type' => 1,
            'comment' => $task['tickectRequest']['ticket_comment'],
            'expected_complete_time' => $expectedCompletedTime,
            'created_by' => auth()->user()->id,
            'created_at' => Carbon::now()->timestamp,
            'updated_at' => Carbon::now()->timestamp,
            'auto_ticket_req_id' => !empty($automaticTicket['data']['id']) ? $automaticTicket['data']['id'] : null
        ]);
    }

    /**
     * create new auto ticket
     *
     * @param integer $processId
     * @return array
     */
    private function createAutomaticTicket(int $processId): array
    {
        return $this->ticketRequestService->create([
            'name' => Str::random(20),
            'department_id' => 1,
            'process_id' => $processId,
            'ticket_serial' => Str::random(20),
            'request_time' => Carbon::now()->timestamp,
            'finish_time' => Carbon::now()->timestamp,
            'priority' => 1,
            'ticket_comment' => Str::random(20),
            'ticket_action' => 1,
            'approval_status' => 1,
            'created_by' => 1,
            'created_at' => Carbon::now()->timestamp,
            'updated_at' => Carbon::now()->timestamp,
            'ticket_type' => 2
        ]);
    }

    /**
     * count status for each task type
     *
     * @SuppressWarnings(PHPMD.ElseExpression)
     * @param object $req
     * @param array $count
     * @return array
     */
    private function countStatusTask(object $req, array $count): array
    {
        if ($req->status == Task::STATUS_ACTIVE) {
            if (Carbon::now('Asia/Ho_Chi_Minh')->timestamp <= $req->expected_complete_time) {
                $count['waitingOnTime']++;
            } else {
                $count['waitingOutTime']++;
            }
            $count['total']++;
        } elseif ($req->status == Task::STATUS_COMPLETE) {
            if ($req->actual_complete_time <= $req->expected_complete_time) {
                $count['taskOnTime']++;
            } else {
                $count['taskOutTime']++;
            }
            $count['total']++;
        }

        return $count;
    }

    /**
     * check param to add query get all
     *
     * @SuppressWarnings(PHPMD)
     *
     * @param object $repository
     * @param array $params
     * @param boolean $isTask
     * @param boolean $isCheck
     * @return object
     */
    private function addFilterByParams(object $repository, array $params, bool $isTask, bool $isCheck): object
    {
        if ($isTask == false) {
            if ($isCheck == true && !empty($params['nameProcessOrCodeTicket'])) {
                $repository = $repository->where('name', 'like', '%' . $params['nameProcessOrCodeTicket'] . '%');
                return $repository;
            }
            if (!empty($params['version'])) {
                $repository = $repository->where('version', $params['version']);
            }
            if (!empty($params['owner_department_id'])) {
                $repository = $repository->where('owner_department_id', $params['owner_department_id']);
            }
            if (isset($params['approval_status'])) {
                $repository = $repository->where('approval_status', $params['approval_status']);
            }
            if (!empty($params['request_completion_time_start']) && !empty($params['request_completion_time_end'])) {
                $rTimeStart = $params['request_completion_time_start'];
                $rTimeEnd = $params['request_completion_time_end'];
                $repository = $repository->whereBetween('request_completion_time', [$rTimeStart, $rTimeEnd]);
            }
            if (!empty($params['nameOrCode'])) {
                $repository = $repository->where('name', 'like', '%' . $params['nameOrCode'] . '%')
                    ->orWhere('code', 'like', '%' . $params['nameOrCode'] . '%');
            }
            return $repository;
        }
        if (!empty($params['actual_complete_time_start']) && !empty($params['actual_complete_time_end'])) {
            $actualTimeStart = $params['actual_complete_time_start'];
            $actualTimeEnd = $params['actual_complete_time_end'];
            $repository = $repository->whereBetween('actual_complete_time', [$actualTimeStart, $actualTimeEnd]);
        }
        return $repository;
    }

    /**
     * Get task with each type and valid
     *
     * @param object $processes
     * @param array $taskId
     * @return array
     */
    private function getProcessWithTask(object $processes, array $taskId): array
    {

        foreach ($processes as $process) {
            $newTask = [];
            $count = [
                'normal' => [
                    'taskOnTime' => 0,
                    'taskOutTime' => 0,
                    'waitingOnTime' => 0,
                    'waitingOutTime' => 0,
                    'total' => 0
                ],
                'auto' => [
                    'taskOnTime' => 0,
                    'taskOutTime' => 0,
                    'waitingOnTime' => 0,
                    'waitingOutTime' => 0,
                    'total' => 0
                ],
                'total' => [
                    'taskOnTime' => 0,
                    'taskOutTime' => 0,
                    'waitingOnTime' => 0,
                    'waitingOutTime' => 0,
                    'total' => 0
                ]
            ];
            foreach ($process['tasks'] as $key => $task) {
                if (!in_array($task->id, $taskId)) {
                    unset($process['tasks'][$key]);
                    continue;
                }
                array_push($newTask, $task);
                if ($task->task_type == Task::TASK_NORMAL) {
                    $count['normal'] = $this->countStatusTask($task, $count['normal']);
                } elseif ($task->task_type == Task::TASK_AUTO) {
                    $count['auto'] = $this->countStatusTask($task, $count['auto']);
                }
            }
            unset($process['tasks']);
            $process['tasks'] = $newTask;
            $count['total']['taskOnTime'] = $count['normal']['taskOnTime'] + $count['auto']['taskOnTime'];
            $count['total']['taskOutTime'] = $count['normal']['taskOutTime'] + $count['auto']['taskOutTime'];
            $count['total']['waitingOnTime'] = $count['normal']['waitingOnTime'] + $count['auto']['waitingOnTime'];
            $count['total']['waitingOutTime'] = $count['normal']['waitingOutTime'] + $count['auto']['waitingOutTime'];
            $count['total']['total'] = $count['normal']['total'] + $count['auto']['total'];
            $process['count'] = $count;
        }
        return $processes->toArray();
    }
}
