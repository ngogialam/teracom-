<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ProcessComments.
 *
 * @package namespace App\Models;
 */
class ProcessComments extends Model implements Transformable
{
    use TransformableTrait;

    protected $dateFormat = 'U';

    protected $table = 'process_comments';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'process_id',
        'comment',
        'created_at',
        'updated_at'
    ];
}
