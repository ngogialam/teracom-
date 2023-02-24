<?php

namespace App\Services;

use App\Http\Controllers\BaseController;
use App\Models\Task;
use App\Models\TicketApprovalLog;
use App\Models\TicketRequest;
use App\Repositories\ProcessStepRepositoryInterface;
use App\Repositories\TaskRepositoryInterface;
use App\Repositories\TicketApprovalLogRepositoryInterface;
use App\Repositories\TicketRequestRepositoryInterface;
use App\Models\ProcessStep;
use Illuminate\Support\Carbon;
use Illuminate\Support\Arr;
use App\Repositories\ProcessRepositoryInterface;

/**
 * @SuppressWarnings(PHPMD)
 */
class TicketRequestService
{
    public function __construct(
        protected TicketRequestRepositoryInterface $repository,
        protected TaskRepositoryInterface $taskRepository,
        protected ProcessStepRepositoryInterface $processStepRepository,
        protected TicketApprovalLogRepositoryInterface $ticketApprovalLogRepository,
        protected ProcessRepositoryInterface $processRepository
    ) {
        //
    }

    /**
     * get all tickets request
     *
     * @param array $params
     * @return array
     */
    public function all(array $params): array
    {
        $limit = $params['limit'] ?? BaseController::DEFAULT_LIMIT;
        $page = $params['page'] ?? BaseController::DEFAULT_PAGE;
        $repository = $this->repository;

        if (!empty($params['created_by'])) {
            $repository = $repository->where('created_by', $params['created_by']);
        }
        $totalItem = $repository->count();
        $ticketRequests = $repository->with(['tasks', 'process', 'objects'])->orderBy('id', 'desc')
            ->skip(($page - 1) * $limit)
            ->take($limit)
            ->get();

        return [
            'list'      => $ticketRequests->toArray(),
            'limit'     => $limit,
            'page'      => $page,
            'totalItem' => $totalItem
        ];
    }

    /**
     * create new ticket request
     * @SuppressWarnings(PHPMD)
     *
     * @param array $params
     * @return array
     */
    public function create(array $params): array
    {
        $stepId = $slaQuantity = $slaUnit = 0;
        $totalTimeCompleted = $requestTime = Carbon::now('Asia/Ho_Chi_Minh');
        if (!empty($params['request_time'])) {
            $requestTime = Carbon::createFromTimestamp($params['request_time']);
        }
        $process = $this->processRepository->find($params['process_id']);
        $processCode = $process['data']['code'];
        $processShort = $process['data']['short_name'];
        $processVersion = $process['data']['version'];
        $ticketRequests = $this->repository->findWhere([
            ['code', 'like', '%' . $process['data']['code'] . '%']
        ]);

        if (!empty($ticketRequests['data'])) {
            $codeTail = (int)substr($ticketRequests['data'][0]['code'], -6) + count($ticketRequests['data']);
            $codeTail = sprintf("%0" . (TicketRequest::NUMBER_OF_CHARACTERS - strlen($codeTail)) . "d", $codeTail);
            $processCode = $processCode . '_' . $processShort . '_' . $processVersion;
            $params['code'] = $this->convertTicketCode($processCode, $codeTail);
        } else {
            $processCode = $processCode . '_' . $processShort . '_' . $processVersion;
            $params['code'] = $this->convertTicketCode($processCode, TicketRequest::TICKET_REQUEST_FIRST);
        }
        $params['created_by'] = auth()->user()->id;
        $processSteps = $this->processStepRepository->findWhere(['process_id' => $params['process_id']]);
        foreach ($processSteps['data'] as $processStep) {
            if ($processStep['step_type'] != ProcessStep::STEP_TYPE_START) {
                $requestTime = Carbon::createFromTimestamp($totalTimeCompleted);
            }
            $totalTimeCompleted = convertSla($processStep['sla_quantity'], $processStep['sla_unit'], $requestTime);
        }

        if (empty($params['request_time'])) {
            $params['request_time'] = Carbon::now('Asia/Ho_Chi_Minh')->timestamp;
        }
        $params['finish_time'] = $totalTimeCompleted;
        $ticketRequest = $this->repository->create(abandonNulValue($params));
        foreach ($processSteps['data'] as $processStep) {
            if ($processStep['step_type'] == ProcessStep::STEP_TYPE_START) {
                $stepId = $processStep['id'];
                $slaUnit = $processStep['sla_unit'];
                $slaQuantity = $processStep['sla_quantity'];
            }
        }

        if ($stepId != 0 && $slaQuantity != 0 && $slaUnit != 0) {
            $slaQuantity = $processSteps['data'][0]['sla_quantity'];
            $slaUnit = $processSteps['data'][0]['sla_unit'];
            $code = $params['code'] . '_' . Task::STEP_SHORT_NAME . Task::TASK_OF_STEP_FIRST;
            $this->taskRepository->create(abandonNulValue([
                'code' => $code,
                'ticket_req_id' => $ticketRequest['data']['id'],
                'step_id' => $stepId,
                'task_type' => Task::TASK_NORMAL,
                'assignee_id' => 1,
                'department_id' => $ticketRequest['data']['department_id'],
                'action' => $ticketRequest['data']['ticket_action'] ?? Task::TASK_ACTION_NOTHING,
                'approval_status' => $ticketRequest['data']['approval_status'] ?? Task::APPROVAL_STATUS_DRAFT,
                'rollback_step_id' => $stepId,
                'rollback_type' => 1,
                'comment' => $ticketRequest['data']['comment'],
                'expected_complete_time' => convertSla($slaQuantity, $slaUnit, Carbon::now('Asia/Ho_Chi_Minh')),
                'created_at' => Carbon::now()->timestamp,
                'updated_at' => Carbon::now()->timestamp,
            ]));
            $this->createLog($ticketRequest, $params, true);
        }

        return $ticketRequest;
    }

    /**
     * show ticket request by id
     *
     * @param int $id
     * @return array
     */
    public function show(int $id): array
    {
        return $this->repository->with(['tasks', 'process', 'objects'])->find($id);
    }

    /**
     * update ticket request
     *
     * @param array $params
     * @param int $id
     * @return void
     */
    public function update(array $params, int $id): void
    {
        $ticketRequest = $this->repository->update($params, $id);
        $this->createLog($ticketRequest, $params, false);
    }

    /**
     * delete ticket request by id
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    /**
     * get process with ticket request
     *
     * @param array $params
     * @return array
     */
    public function getProcessTicketRequests(array $params): array
    {
        if (empty($params['created_by'])) {
            return ['data' => []];
        }
        $processIds = $ticketIds = [];
        $limit = $params['limit'] ?? BaseController::DEFAULT_LIMIT;
        $page = $params['page'] ?? BaseController::DEFAULT_PAGE;
        $isCheck = true;
        $processRepository = $this->processRepository;
        $repository = $this->repository->where('created_by', $params['created_by']);
        $repository = $this->addFilterByParams($repository, $params, true, $isCheck);
        if (!empty($params['nameProcessOrCodeTicket'])) {
            $repository = $repository->where('code', 'like', '%' . $params['nameProcessOrCodeTicket'] . '%');
            $count = $repository->count();
            if ($count == 0) {
                $repository = $this->repository->where('created_by', $params['created_by']);
                $repository = $this->addFilterByParams($repository, $params, true, $isCheck);
            }

            if ($count > 0) {
                $isCheck = false;
            }
        }
        $ticketRequests = $repository->get();
        foreach ($ticketRequests as $ticketRequest) {
            array_push($processIds, $ticketRequest['process']['id']);
            array_push($ticketIds, $ticketRequest['id']);
        }
        $processRepository =  $processRepository->with('ticketRequest')
            ->whereIn('id', array_unique($processIds));
        $processRepository = $this->addFilterByParams($processRepository, $params, false, $isCheck);
        $totalItem = $processRepository->whereIn('id', array_unique($processIds))->count();
        $process = $processRepository->skip(($page - 1) * $limit)->take($limit)->get();
        $process = $this->getProcessWithTicketRequest($process, $ticketIds);
        $newProcess = [
            'data' => [
                'list' => $process,
                'limit' => $limit,
                'page' => $page,
                'totalItem' => $totalItem
            ]
        ];
        return $newProcess;
    }

    /**
     * get ticket request with each status by ticket id and params
     *
     * @param integer $processId
     * @param array $params
     * @return array
     */
    public function getProcessTicketRequestDefault(int $processId, array $params): array
    {
        if (empty($processId) || empty($params['created_by'])) {
            return [];
        }
        $draft = $processing = $completed = $reject = 0;
        $ticketIds = [];
        $isCheck = true;
        $repository = $this->repository
            ->where('process_id', $processId)
            ->where('created_by', $params['created_by']);
        $repository = $this->addFilterByParams($repository, $params, true, $isCheck);
        if (!empty($params['nameProcessOrCodeTicket'])) {
            $repository = $repository->where('code', 'like', '%' . $params['nameProcessOrCodeTicket'] . '%');
            $count = $repository->count();
            if ($count == 0) {
                $repository = $this->repository
                    ->where('process_id', $processId)
                    ->where('created_by', $params['created_by']);
            }
            if ($count > 0) {
                $isCheck = false;
            }
        }
        $ticketRequests = $repository->get();
        foreach ($ticketRequests as $ticketRequest) {
            array_push($ticketIds, $ticketRequest['id']);
        }
        $processRepository = $this->processRepository;
        $processRepository = $processRepository->skipPresenter()->with('ticketRequest')->where('id', $processId);
        $processRepository = $this->addFilterByParams($processRepository, $params, false, $isCheck);
        $process = $processRepository->get();
        if (empty($process[0]) || empty($ticketIds)) {
            return [];
        }
        $ticketRequest = [];
        foreach ($process[0]['ticketRequest'] as $key => $value) {
            if (!in_array($value->id, $ticketIds)) {
                unset($process[0]['ticketRequest'][$key]);
                continue;
            }
            array_push($ticketRequest, $value);
            switch ($value->approval_status) {
                case TicketRequest::APPROVAL_STATUS_DRAFT:
                    $draft++;
                    break;
                case TicketRequest::APPROVAL_STATUS_PROCESSING:
                    $processing++;
                    break;
                case TicketRequest::APPROVAL_STATUS_COMPLETED:
                    $completed++;
                    break;
                case TicketRequest::APPROVAL_STATUS_REJECT:
                    $reject++;
                    break;
                default:
                    break;
            }
        }
        unset($process[0]['ticketRequest']);
        $process[0]['ticket_request'] = $ticketRequest;
        return [
            'list' => $process,
            'count' => [
                'draft' => $draft,
                'processing' => $processing,
                'completed' => $completed,
                'reject' => $reject
            ]
        ];
    }

    /**
     * create log when ticket request has change
     *
     * @param $ticket
     * @param array $params
     * @param bool $isNewTicketRequest
     * @return void
     */
    private function createLog($ticket, array $params, bool $isNewTicketRequest): void
    {
        $paramsApprovalStatus = Arr::get($params, 'approval_status');
        if (!$paramsApprovalStatus) {
            return;
        }
        $approvalStatus = Arr::get($ticket, 'data.approval_status');
        if ($isNewTicketRequest) {
            $approvalStatus =  TicketApprovalLog::APPROVAL_STATUS_DRAFT;
        }
        $data = [
            'ticket_req_id' => Arr::get($ticket, 'data.id'),
            'approval_status' => $approvalStatus,
            'comment' => Arr::get($ticket, 'data.comment'),
            'created_by' => auth()->user()->id,
            'updated_at' =>  Carbon::now()->timestamp,
            'created_at' =>  Carbon::now()->timestamp,
            'updated_by' => auth()->user()->id
        ];
        $this->ticketApprovalLogRepository->create(abandonNulValue($data));
    }

    /**
     * check param to add query to get all ticket request
     *
     * @param object $repository
     * @param array $params
     * @param boolean $isTicket
     * @param boolean $isCheck
     * @return object
     */
    private function addFilterByParams(object $repository, array $params, bool $isTicket, bool $isCheck): object
    {
        if ($isTicket == false) {
            if ($isCheck == true && !empty($params['nameProcessOrCodeTicket'])) {
                $repository = $repository->where('name', 'like', '%' . $params['nameProcessOrCodeTicket'] . '%');
                return $repository;
            }
            if (!empty($params['version'])) {
                $repository = $repository->where('version', $params['version']);
            }
            if (isset($params['approval_status'])) {
                $repository = $repository->where('approval_status', $params['approval_status']);
            }
            if (!empty($params['nameOrCode'])) {
                $repository =  $repository->where('name', 'like', '%' . $params['nameOrCode'] . '%')
                    ->orWhere('process_code', 'like', '%' . $params['nameOrCode'] . '%');
            }
            return $repository;
        }
        if (!empty($params['code'])) {
            $repository = $repository->where('code', 'like', '%' . $params['code'] . '%');
        }
        if (
            isset($params['approval_status_ticket'])
            && $params['approval_status_ticket'] != TicketRequest::APPROVAL_STATUS_ALL
        ) {
            $repository = $repository->where('approval_status', $params['approval_status_ticket']);
        }
        if (!empty($params['request_time_start']) && !empty($params['request_time_end'])) {
            $rTimeStart = $params['request_time_start'];
            $rTimeEnd = $params['request_time_end'];
            $repository = $repository->whereBetween('request_time', [$rTimeStart, $rTimeEnd]);
        }
        return $repository;
    }

    /**
     * get data process with ticket request
     *
     * @param object $processes
     * @param array $ticketIds
     * @return array
     */
    private function getProcessWithTicketRequest(object $processes, array $ticketIds): array
    {
        foreach ($processes as $process) {
            $draft = 0;
            $processing = 0;
            $completed = 0;
            $reject = 0;
            $ticketRequest = [];
            foreach ($process['ticketRequest'] as $key => $value) {
                if (!in_array($value->id, $ticketIds)) {
                    unset($process['ticketRequest'][$key]);
                    continue;
                }
                array_push($ticketRequest, $value);
                switch ($value->approval_status) {
                    case TicketRequest::APPROVAL_STATUS_DRAFT:
                        $draft++;
                        break;
                    case TicketRequest::APPROVAL_STATUS_PROCESSING:
                        $processing++;
                        break;
                    case TicketRequest::APPROVAL_STATUS_COMPLETED:
                        $completed++;
                        break;
                    case TicketRequest::APPROVAL_STATUS_REJECT:
                        $reject++;
                        break;
                }
            }
            unset($process['ticketRequest']);
            $process['ticket_request'] = $ticketRequest;
            $process['count'] = [
                'draft' => $draft,
                'processing' => $processing,
                'completed' => $completed,
                'reject' => $reject
            ];
        }
        return $processes->toArray();
    }

    /**
     * convert Ticket Code with processCode and codeTail
     *
     * @param string $processCode
     * @param string $codeTail
     * @return string
     */
    private function convertTicketCode(string $processCode, string $codeTail): string
    {
        return $processCode . '_' . date("y") . '_' . $codeTail;
    }
}
