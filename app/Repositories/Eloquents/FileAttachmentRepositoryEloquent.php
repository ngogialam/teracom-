<?php

namespace App\Repositories\Eloquents;

use App\Models\FileAttachment;
use App\Repositories\FileAttachmentRepositoryInterface;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Validators\FileAttachmentValidator;

/**
 * Class FileAttachmentRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class FileAttachmentRepositoryEloquent extends BaseRepository implements FileAttachmentRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FileAttachment::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return FileAttachmentValidator::class;
    }

    public function presenter()
    {
        return "App\\Presenters\\FileAttachmentPresenter";
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
