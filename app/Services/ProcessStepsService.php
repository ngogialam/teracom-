<?php

namespace App\Services;

use App\Models\FileAttachment;
use App\Models\StepTransferCondition;
use App\Repositories\FileAttachmentRepositoryInterface;
use App\Repositories\ProcessStepRepositoryInterface;
use App\Repositories\StepTransferConditionRepositoryInterface;

class ProcessStepsService
{
    public function __construct(
        protected ProcessStepRepositoryInterface $repository,
        protected StepTransferConditionRepositoryInterface $stepTransferConditionRepository,
        protected FileAttachmentRepositoryInterface $attachmentRepository
    ) {
        //
    }

    /**
     * Get all process steps
     *
     * @param array $params
     * @return array
     */
    public function all(array $params): array
    {
        $processSteps = $this->repository;
        if (!empty($params['process_id'])) {
            $processSteps = $processSteps->where('process_id', $params['process_id']);
        }
        return $processSteps->all();
    }

    /**
     * Create new process step
     *
     * @param array $params
     * @return array
     */
    public function create(array $params): array
    {
        $processStep = $this->repository->create(abandonNulValue($params));

        if (!empty($params['file_attachment_ids'])) {
            $this->attachment($processStep['data']['id'], $params['file_attachment_ids']);
        }

        if (!empty($params['step_transfer_conditions']) && is_array($params['step_transfer_conditions'])) {
            if (!isGoodArrayBeforeInsert($params['step_transfer_conditions'])) {
                return $processStep;
            }
            $stepTransferCondition = new StepTransferCondition();
            foreach ($params['step_transfer_conditions'] as $key => $stepTC) {
                foreach ($stepTC as $kField => $field) {
                    if (!in_array($kField, $stepTransferCondition->getFillable())) {
                        unset($params['step_transfer_conditions'][$key][$kField]);
                    }
                }
                $params['step_transfer_conditions'][$key]['step_id'] = $processStep['data']['id'];
            }
            $this->stepTransferConditionRepository->insert($params['step_transfer_conditions']);
        }
        return $processStep;
    }

    /**
     * Show process step by id
     *
     * @param integer $id
     * @return array
     */
    public function show(int $id): array
    {
        $processStep = $this->repository->with(['stepTransferConditions'])->find($id);
        $processStep['data']['fileAttachments'] = $this->getFileAttachment($id);

        return $processStep;
    }

    /**
     * update process step by id
     *
     * @param array $params
     * @param integer $id
     * @return void
     */
    public function update(array $params, int $id): void
    {
        $this->repository->update($params, $id);
    }

    /**
     * delete process step by id
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    /**
     * add attachment files to process step
     *
     * @param integer $processStepId
     * @param array $attachmentIds
     * @return void
     */
    public function attachment(int $processStepId, array $attachmentIds): void
    {
        foreach ($attachmentIds as $attachmentId) {
            $this->attachmentRepository->update([
                'target_id' => $processStepId,
                'target_type' => FileAttachment::TARGET_TYPE_STEP
            ], $attachmentId);
        }
    }

    /**
     * get attachment file by process step id
     *
     * @param integer $id
     * @return array
     */
    public function getFileAttachment(int $id): array
    {
        $processAttachments = $this->attachmentRepository->findwhere([
            'target_id' => $id,
            'target_type' => FileAttachment::TARGET_TYPE_STEP
        ]);
        return $processAttachments['data'];
    }
}
