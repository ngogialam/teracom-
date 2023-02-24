<?php

namespace App\Services;

use App\Repositories\ApprovalProcessRepositoryInterface;

class ApprovalProcessService
{
    public function __construct(
        protected ApprovalProcessRepositoryInterface $repository,
    ) {
        //
    }

    /**
     * Get Process Approve by process id
     *
     * @param array $params
     * @return array
     */
    public function all(array $params): array
    {
        if (empty($params['process_id'])) {
            return [];
        }
        return $this->repository->findWhere(['process_id' => $params['process_id']]);
    }
}
