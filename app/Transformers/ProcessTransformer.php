<?php

namespace App\Transformers;

use App\Models\FileAttachment;
use League\Fractal\TransformerAbstract;
use App\Models\Process;
use App\Models\StepObject;

/**
 * Class ProcessTransformer.
 *
 * @package namespace App\Transformers;
 */
class ProcessTransformer extends TransformerAbstract
{
    /**
     * Transform the Process entity.
     *
     * @param \App\Models\Process $model
     *
     * @return array
     */
    public function transform(Process $model): array
    {
        return [
            'id' => $model['id'],
            'code' => $model['code'],
            'name' => $model['name'],
            'short_name' => $model['short_name'],
            'owner_deparment_id' => $model['owner_deparment_id'],
            'target_apply_type' => $model['target_apply_type'],
            'regulation_document' => $model['regulation_document'],
            'regulation_start_date' => $model['regulation_start_date'],
            'regulation_end_date' => $model['regulation_end_date'],
            'description' => $model['description'],
            'approval_status' => $model['approval_status'],
            'approval_target_type' => $model['approval_target_type'],
            'version' => $model['version'],
            'created_by' => $model['created_by'],
            'updated_by' => $model['updated_by'],
            'status' => $model['status'],
            'process_id' => $model['process_id'],
            'required_time' => $model['required_time'],
            'request_completion_time' => $model['request_completion_time'],
            'activation_date' => $model['activation_date'],
            'out_of_date' => $model['out_of_date'],
            'process_code' => $model['process_code'],
            'processChangeLogs' => $model['processChangeLogs'] ?? null,
            'processSteps' => $this->processStep($model),
            'approvalProcessLogs' => $model['approvalProcessLogs'] ?? null,
            'processObject' => $this->processObject($model) ?? null,
            'tasks' => $model['tasks'] ?? null,
            'fileAttachments' => $model['fileAttachments'] ?? null,
            'ticketRequest' => $model['ticketRequest'] ?? null,
            'processComment' => $model['processComment'] ?? null
        ];
    }

    private function processObject(object $model): array
    {
        $processObject = [];
        foreach ($model['stepObject'] as $stepObject) {
            if ($stepObject->step_id == null) {
                array_push($processObject, $stepObject);
            }
        }

        return $processObject;
    }

    private function stepObjectStatus(object $stepObjects, int $status): array
    {
        $stepObjectsWithStatus = [];
        foreach ($stepObjects as $stepObject) {
            if ($stepObject->object_action_type == $status) {
                array_push($stepObjectsWithStatus, $stepObject);
            }
        }
        return $stepObjectsWithStatus;
    }

    private function mapDataProcessStep(int $stepId, array $allProcessSteps): array
    {
        $processSteps = [];
        foreach ($allProcessSteps as $processStep) {
            if ($stepId == $processStep['step_id']) {
                array_push($processSteps, $processStep);
            }
        }
        return $processSteps;
    }

    private function processStep(object $model): object
    {
        foreach ($model['processSteps'] as $step) {
            $actionReceiveInfo = StepObject::OBJECT_ACTION_TYPE_RECEIVE_INFORMATION;
            $stepObjectInfo = $this->stepObjectStatus($model['stepObject'], $actionReceiveInfo);
            $stepObjectPerform = $this->stepObjectStatus($model['stepObject'], StepObject::OBJECT_ACTION_TYPE_EXECUTOR);
            $step['stepCheckList'] = $this->mapDataProcessStep($step->id, $model['stepCheckList']->toArray());
            $step['stepTransferCondition'] = $this->mapDataProcessStep($step->id, $model['stepTransferCondition']->toArray());
            $step['childProcessStep'] = !empty($step->child_process_id) ? Process::find($step->child_process_id) : null;
            $step['stepObjectInfo'] = $this->mapDataProcessStep($step->id, $stepObjectInfo);
            $step['stepObjectPerform'] = $this->mapDataProcessStep($step->id, $stepObjectPerform);
            $step['fileAttachments'] = $this->getProcessStepAttachments($step->id);
        }
        return $model['processSteps'];
    }

    private function getProcessStepAttachments($processStepId)
    {
        return FileAttachment::where([
            'target_id' => $processStepId,
            'target_type' => FileAttachment::TARGET_TYPE_STEP
        ])->get();
    }
}
