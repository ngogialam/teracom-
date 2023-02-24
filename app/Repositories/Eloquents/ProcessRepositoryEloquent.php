<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Process;
use App\Models\ProcessStep;
use App\Repositories\ProcessRepositoryInterface;
use App\Validators\ProcessValidator;

/**
 * Class ProcessRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class ProcessRepositoryEloquent extends BaseRepository implements ProcessRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Process::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return ProcessValidator::class;
    }

    public function presenter()
    {
        return "App\\Presenters\\ProcessPresenter";
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @return array
     */
    public function getProcessWithStatusApproveAndFirstStep(): array
    {
        $process = $this->model->select('process.*')
            ->where('approval_status', Process::APPROVAL_STATUS_APPROVE)
            ->leftJoin('process_step', function ($join) {
                $join->on('process.id', '=', 'process_step.process_id')
                    ->where('step_type', ProcessStep::STEP_TYPE_START);
            })
            ->leftJoin('step_object', function ($join) {
                $join->on('process_step.id', '=', 'step_object.step_id')
                    ->where('object_id', auth()->user()->id);
            })->distinct()->get()->toArray();
        foreach ($process as $key => $value) {
            $process[$key]['name'] = $value['name'] . '_' . $value['version'];
        }
        return $process;
    }
}
