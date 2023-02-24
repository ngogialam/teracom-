<?php

namespace App\Services;

use App\Exceptions\DuplicateException;
use App\Exceptions\NotAcceptableException;
use App\Http\Controllers\BaseController;
use App\Models\FileAttachment;
use App\Models\Process;
use App\Models\ApprovalProcessLog;
use App\Models\ProcessChangeLog;
use App\Models\ProcessStep;
use App\Repositories\FileAttachmentRepositoryInterface;
use App\Repositories\ApprovalProcessRepositoryInterface;
use App\Repositories\ProcessChangeLogRepositoryInterface;
use App\Repositories\ProcessCommentsRepositoryInterface;
use App\Repositories\ProcessRepositoryInterface;
use App\Repositories\ProcessStepRepositoryInterface;
use App\Repositories\StepObjectRepositoryInterface;
use Carbon\Carbon;

/**
 * @SuppressWarnings(PHPMD)
 */
class ProcessesService
{
    public function __construct(
        protected ProcessRepositoryInterface $repository,
        protected ProcessStepRepositoryInterface $processStepRepository,
        protected FileAttachmentRepositoryInterface $attachmentRepository,
        protected ProcessChangeLogRepositoryInterface $processChangeLogRepository,
        protected ApprovalProcessRepositoryInterface $approvalProcessLogRepository,
        protected StepObjectRepositoryInterface $stepObjectRepository,
        protected ProcessStepsService $stepsService,
        protected ProcessCommentsRepositoryInterface $processCommentsRepository
    ) {
        //
    }

    /**
     * Get all Process
     *
     * @param array $params
     * @return array
     */
    public function all(array $params): array
    {
        $limit = $params['limit'] ?? BaseController::DEFAULT_LIMIT;
        $page = $params['page'] ?? BaseController::DEFAULT_PAGE;
        $repository = $this->repository;
        $count = [];
        if (!empty($params['user_id'])) {
            $processIds = [];
            $stepObjects = $this->stepObjectRepository->findWhere(['object_id' => $params['user_id']]);
            foreach ($stepObjects['data'] as $stepObject) {
                if (
                    !empty($stepObject['process'])
                    && $stepObject['process']['approval_status'] !== Process::APPROVAL_STATUS_DRAFT
                ) {
                    array_push($processIds, $stepObject['process']['id']);
                }
            }
            $repository = $repository->whereIn('id', array_unique($processIds));
            $count = $this->getEachTypeOfProcess($processIds);
        } elseif (!empty($params['created_by'])) {
            $repository = $repository->where('created_by', $params['created_by']);
            $count = $this->countProcessStatus($params);
        } elseif (!empty($params['auth_do_first_step'])) {
            return $this->repository->getProcessWithStatusApproveAndFirstStep();
        }

        $repository = $this->addFilterByParams($repository, $params);

        $processes = $repository->with([
            'processSteps', 'processChangeLogs', 'approvalProcessLogs',
            'stepObject', 'stepTransferCondition', 'stepCheckList'
        ])->orderBy('approval_status', 'asc')
            ->orderBy('created_at', 'desc')
            ->skip(($page - 1) * $limit)
            ->take($limit)
            ->get();

        return [
            'list'  => $processes->toArray(),
            'count' => $count,
            'limit' => $limit,
            'page'  => $page
        ];
    }

    /**
     * Create new process
     *
     * @param array $params
     * @return array
     */
    public function create(array $params): array
    {
        if (!empty($params['version']) && !empty($params['process_id'])) {
            $process = $this->repository->findWhere([
                'process_id' => $params['process_id'],
                'version'    => $params['version']
            ]);
            if (count($process['data']) > 0) {
                throw new NotAcceptableException("Version is already exists");
            }
        } else {
            $isDuplicateShortName = $this->isDuplicateShortName(abandonNulValue($params));
            if ($isDuplicateShortName) {
                throw new DuplicateException("Short name is already exists");
            }
        }
        if (!empty($params['version']) && !empty($params['short_name']) && !empty($params['code'])) {
            $params['process_code'] = $this->convertCodeProcess($params);
        }
        $process = $this->repository->create(abandonNulValue($params));

        if (!empty($params['file_attachment_ids'])) {
            $this->attachment($process['data']['id'], $params['file_attachment_ids']);
        }

        if (!empty($params['process_id'])) {
            $this->makeChangeLog(ProcessChangeLog::CHANGE_TYPE_NEW_VERSION, $params['process_id']);
        } elseif (!empty($params['copy_process_id'])) {
            $oldProcess = $this->repository->find($params['copy_process_id']);
            $this->makeChangeLog(ProcessChangeLog::CHANGE_TYPE_COPY, $oldProcess['data']['id']);
        }

        if (!empty($params['process_steps']) && is_array($params['process_steps'])) {
            if (!isGoodArrayBeforeInsert($params['process_steps'])) {
                return $process;
            }
            foreach ($params['process_steps'] as $key => $processStep) {
                $params['process_steps'][$key]['process_id'] = $process['data']['id'];
                $processStep = $this->processStepRepository->create($params['process_steps'][$key]);

                if (!empty($params['process_steps'][$key]['file_attachment_ids'])) {
                    $fileAttachmentIds = $params['process_steps'][$key]['file_attachment_ids'];
                    $this->stepsService->attachment($processStep['data']['id'], $fileAttachmentIds);
                }
            }
        }

        $this->makeChangeLog(ProcessChangeLog::CHANGE_TYPE_DEFAULT, $process['data']['id']);
        $this->createApprovalDefault($process['data']['id']);

        return $process;
    }

    /**
     * Get process by id
     *
     * @param integer $id
     * @return array
     */
    public function show(int $id): array
    {
        $process = $this->repository->with([
            'processSteps', 'processChangeLogs', 'approvalProcessLogs', 'stepObject',
            'stepTransferCondition', 'stepCheckList'
        ])->find($id);
        $process['data']['fileAttachments'] = $this->getFileAttachment($id);
        return $process;
    }

    /**
     * add attachment files to process
     *
     * @param integer $processId
     * @param array $attachmentIds
     * @return void
     */
    public function attachment(int $processId, array $attachmentIds): void
    {
        $this->attachmentRepository->where('target_type', FileAttachment::TARGET_TYPE_PROCESS)
            ->update(['target_id' => null]);
        foreach ($attachmentIds as $attachmentId) {
            $this->attachmentRepository->update([
                'target_id' => $processId,
                'target_type' => FileAttachment::TARGET_TYPE_PROCESS
            ], $attachmentId);
        }
    }

    /**
     * create approval default when create,copy new process
     *
     * @param integer $processId
     * @return void
     */
    public function createApprovalDefault(int $processId): void
    {
        $faker = \Faker\Factory::create();
        $this->approvalProcessLogRepository->insert([
            [
                'name' => auth()->user()->name ?? ApprovalProcessLog::DEFAULT_NAME,
                'email' => auth()->user()->email ?? ApprovalProcessLog::DEFAULT_EMAIL,
                'process_id' => $processId,
                'approval_status' => ApprovalProcessLog::APPROVE_STATUS_COMPLETED,
                'comment' => $faker->sentence,
                'created_by' => auth()->user()->id ?? $faker->numerify("##########"),
                'updated_by' => $faker->numerify("##########"),
                'created_at' => Carbon::now()->timestamp,
                'updated_at' => Carbon::now()->timestamp
            ],
            [
                'name' => auth()->user()->name ?? ApprovalProcessLog::DEFAULT_NAME,
                'email' => auth()->user()->email ?? ApprovalProcessLog::DEFAULT_EMAIL,
                'process_id' => $processId,
                'approval_status' => ApprovalProcessLog::APPROVE_STATUS_DOING,
                'comment' => $faker->sentence,
                'created_by' => auth()->user()->id ?? $faker->numerify("##########"),
                'updated_by' => $faker->numerify("##########"),
                'created_at' => Carbon::now()->timestamp,
                'updated_at' => Carbon::now()->timestamp
            ]
        ]);
    }

    /**
     * Get attachment file
     *
     * @param integer $id
     * @return array
     */
    public function getFileAttachment(int $id): array
    {
        $processAttachments = $this->attachmentRepository
            ->findwhere(['target_id' => $id, 'target_type' => FileAttachment::TARGET_TYPE_PROCESS]);
        return $processAttachments['data'];
    }

    /**
     * check duplicate short name of the process
     *
     * @param array $params
     * @return boolean
     */
    public function isDuplicateShortName(array $params): bool
    {
        $params = [
            'short_name' => $params['short_name'],
            'code' => $params['code']
        ];
        $process = $this->repository->findWhere($params);
        return count($process['data']) > 0 ? true : false;
    }

    /**
     * update process
     *
     * @param array $params
     * @param integer $id
     * @return array
     */
    public function update(array $params, int $id): array
    {
        $process = $this->repository->find($id);
        if (!empty($params['file_attachment_ids'])) {
            $this->attachment($process['data']['id'], $params['file_attachment_ids']);
        }
        if (empty($params['version'])) {
            $params['version'] = $process['data']['version'];
        }
        if (empty($params['short_name'])) {
            $params['short_name'] = $process['data']['short_name'];
        }
        if (empty($params['code'])) {
            $params['code'] = $process['data']['code'];
        }
        $params['process_code'] = $this->convertCodeProcess($params);
        $processComment = $this->processCommentsRepository->findWhere(['process_id' => $id]);
        if (!empty($processComment['data'])) {
            if (!empty($params['comment'])) {
                $this->processCommentsRepository->update([
                    'comment' => $params['comment']
                ], $processComment['data'][0]['id']);
            }
        } else {
            $this->processCommentsRepository->create([
                'process_id' => $id,
                'comment' => $params['comment'] ?? null
            ]);
        }
        if (!empty($params['approval_status']) && $process['data']['approval_status'] != $params['approval_status']) {
            if (
                $params['approval_status'] != Process::APPROVAL_STATUS_DRAFT
                && $params['approval_status'] != Process::APPROVAL_STATUS_WAITING
                && $process['data']['request_completion_time'] < Carbon::now()->timestamp
            ) {
                $params['out_of_date'] = 1;
            }

            switch ($params['approval_status']) {
                case Process::APPROVAL_STATUS_WAITING:
                    $params['required_time'] = Carbon::now()->timestamp;
                    $params['request_completion_time'] = $params['required_time'] + addDay();
                    $this->makeChangeLog(ProcessChangeLog::CHANGE_TYPE_WAITING_APPROVE, $process['data']['id']);
                    $this->makeApprovalLog(ApprovalProcessLog::APPROVE_STATUS_COMPLETED, $process['data']['id']);
                    break;
                case Process::APPROVAL_STATUS_APPROVE:
                    $params['activation_date'] = Carbon::now()->timestamp;
                    $this->makeChangeLog(ProcessChangeLog::CHANGE_TYPE_APPROVE, $process['data']['id']);
                    $this->makeApprovalLog(ApprovalProcessLog::APPROVE_STATUS_COMPLETED, $process['data']['id']);
                    break;
                case Process::APPROVAL_STATUS_REJECT:
                    $this->makeChangeLog(ProcessChangeLog::CHANGE_TYPE_DESTROY, $process['data']['id']);
                    $this->makeApprovalLog(ApprovalProcessLog::APPROVE_STATUS_DENIED, $process['data']['id']);
                    break;
            }
        }

        return $this->repository->update(abandonNulValue($params), $id);
    }

    /**
     * delete process by id
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    /**
     * create approval log base on process's action
     *
     * @param integer $approvalStatus
     * @param integer $processId
     * @return void
     */
    private function makeApprovalLog(int $approvalStatus, int $processId): void
    {
        $newApprovalStatus = ApprovalProcessLog::APPROVE_STATUS_DOING;
        $faker = \Faker\Factory::create();
        if ($approvalStatus == ApprovalProcessLog::APPROVE_STATUS_COMPLETED) {
            $approvalSend = $this->approvalProcessLogRepository->findwhere([
                'approval_status' => ApprovalProcessLog::APPROVE_STATUS_DOING,
                'process_id' => $processId
            ]);
            if (!empty($approvalSend['data']) && count($approvalSend['data']) > 0) {
                $this->approvalProcessLogRepository->update([
                    'approval_status' => $approvalStatus,
                ], $approvalSend['data'][count($approvalSend['data']) - 1]['id']);
            }
        } elseif ($approvalStatus == ApprovalProcessLog::APPROVE_STATUS_DENIED) {
            $newApprovalStatus = ApprovalProcessLog::APPROVE_STATUS_DENIED;
        }

        $countApprove = $this->approvalProcessLogRepository->findwhere(['process_id' => $processId]);
        if (count($countApprove['data']) >= 3) {
            return;
        }

        $this->approvalProcessLogRepository->create([
            'name' => auth()->user()->name ?? ApprovalProcessLog::DEFAULT_NAME,
            'email' => auth()->user()->email ?? ApprovalProcessLog::DEFAULT_EMAIL,
            'process_id' => $processId,
            'approval_status' => $newApprovalStatus,
            'comment' => $faker->sentence,
            'created_by' => auth()->user()->id ?? $faker->numerify("##########"),
            'updated_by' => $faker->numerify("##########"),
            'created_at' => Carbon::now()->timestamp,
            'updated_at' => Carbon::now()->timestamp
        ]);
    }

    /**
     * Make change log when have any update from process
     *
     * @param integer $changeLogStatus
     * @param integer $processId
     * @return void
     */
    private function makeChangeLog(int $changeLogStatus, int $processId): void
    {
        $faker = \Faker\Factory::create();
        $this->processChangeLogRepository->create([
            'name' => auth()->user()->name ?? ApprovalProcessLog::DEFAULT_NAME,
            'email' => auth()->user()->email ?? ApprovalProcessLog::DEFAULT_EMAIL,
            'description' => $faker->sentence,
            'created_by' => auth()->user()->id ?? $faker->numerify("##########"),
            'created_at' => Carbon::now()->timestamp,
            'updated_at' => Carbon::now()->timestamp,
            'updated_by' => $faker->numerify("##########"),
            'change_type' => $changeLogStatus,
            'version' => 1,
            'old_version' => 1,
            'process_id' => $processId,
        ]);
    }

    /**
     * check param to add query to get all
     *
     * @param object $repository
     * @param array $params
     * @return object
     */
    private function addFilterByParams(object $repository, array $params): object
    {
        if (!empty($params['name'])) {
            $repository = $repository->where('name', 'like', '%' . $params['name'] . '%');
        }
        if (!empty($params['process_code'])) {
            $repository = $repository->where('process_code', 'like', '%' . $params['process_code'] . '%');
        }
        if (!empty($params['approval_status'])) {
            $repository = $repository->where('approval_status', $params['approval_status']);
        }
        if (!empty($params['owner_deparment_id'])) {
            $repository = $repository->where('owner_deparment_id', $params['owner_deparment_id']);
        }
        if (!empty($params['version'])) {
            $repository = $repository->where('version', $params['version']);
        }
        if (!empty($params['user_id'])) {
            if (!empty($params['request_completion_time_start']) && !empty($params['request_completion_time_end'])) {
                $repository = $repository->whereBetween('request_completion_time', [
                    $params['request_completion_time_start'],
                    $params['request_completion_time_end']
                ]);
            }
            if (!empty($params['activation_date_start']) && !empty($params['activation_date_end'])) {
                $repository = $repository->whereBetween('activation_date', [
                    $params['activation_date_start'],
                    $params['activation_date_end']
                ]);
            }
        } elseif (!empty($params['created_by'])) {
            if (!empty($params['activation_date_start']) && !empty($params['activation_date_end'])) {
                $repository = $repository->whereBetween('activation_date', [
                    $params['activation_date_start'],
                    $params['activation_date_end']
                ]);
            }
        }

        return $repository;
    }

    /**
     * count status for dashboard screen
     *
     * @param array $params
     * @return array
     */
    private function countProcessStatus(array $params): array
    {
        $status = [
            'daft'      => 0,
            'waiting'   => 0,
            'active'    => 0,
            'expire'    => 0
        ];
        if (empty($params['created_by'])) {
            return $status;
        }
        $processes = $this->repository->findWhere(['created_by' => $params['created_by']]);

        foreach ($processes['data'] as $process) {
            switch ($process['approval_status']) {
                case Process::APPROVAL_STATUS_DRAFT:
                    $status['daft']++;
                    break;
                case Process::APPROVAL_STATUS_WAITING:
                    $status['waiting']++;
                    break;
                case Process::APPROVAL_STATUS_APPROVE:
                    $status['active']++;
                    break;
                default:
                    break;
            }
            if ($process['version'] > 1 && $process['approval_status'] == Process::APPROVAL_STATUS_APPROVE) {
                $status['expire'] += $process['version'] - 1;
            }
        }

        return $status;
    }

    /**
     * count status for process sent to me
     *
     * @param array $processIds
     * @return array
     */
    private function getEachTypeOfProcess(array $processIds): array
    {
        $typesOfProcess = [
            'processedOnTime'  => 0,
            'processedOutTime' => 0,
            'waitingOnTime'    => 0,
            'waitingOutTime'   => 0
        ];
        $processes = $this->repository->findWhereIn('id', array_unique($processIds));
        foreach ($processes['data'] as $process) {
            if ($process['approval_status'] == Process::APPROVAL_STATUS_WAITING) {
                if ($process['request_completion_time'] >= Carbon::now()->timestamp) {
                    $typesOfProcess['waitingOnTime']++;
                }
                if ($process['request_completion_time'] < Carbon::now()->timestamp) {
                    $typesOfProcess['waitingOutTime']++;
                }
            } elseif ($process['approval_status'] != Process::APPROVAL_STATUS_DRAFT) {
                if ($process['out_of_date'] == Process::NO_OUT_OF_DATE) {
                    $typesOfProcess['processedOnTime']++;
                }
                if ($process['out_of_date'] == Process::OUT_OF_DATE) {
                    $typesOfProcess['processedOutTime']++;
                }
            }
        }
        return $typesOfProcess;
    }

    /**
     * convert code process by $params
     *
     * @param array $params
     * @return string
     */
    private function convertCodeProcess(array $params): string
    {
        return $params['code'] . '_' . $params['short_name'] . '_' . $params['version'];
    }
}
