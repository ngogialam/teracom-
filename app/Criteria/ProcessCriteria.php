<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Models\Process;

/**
 * Class ProcessCriteria.
 *
 * @package namespace App\Criteria;
 */
class ProcessCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param Process              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        // $model = $model->where('id','=', 1);
        return $model;
    }
}
