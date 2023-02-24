<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository as EloquentBaseRepository;

class BaseRepository extends EloquentBaseRepository
{
    public $model;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return $this->model;
    }
}
