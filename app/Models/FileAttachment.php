<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="FileAttachment",
 *     description="FileAttachment model",
 *     @OA\Xml(
 *         name="FileAttachment"
 *     )
 * )
 * @SuppressWarnings(PHPMD)
 */

class FileAttachment extends Model
{
    use HasFactory;

    const TARGET_TYPE_PROCESS = '1';
    const TARGET_TYPE_TASK = '2';
    const TARGET_TYPE_STEP = '3';
    const TARGET_TYPE_TICKET_REQUEST = '4';

    const DEFAULT_FOLDER = 'G-PROCESS-SERVICE';

    public $timestamps = false;

    protected $table = 'file_attachment';

    /**
     * @OA\Property(
     *      title="file",
     *      description="File of file attachments",
     *      example="example.html",
     * )
     *
     * @var string
     */

    public $file;

    /**
     * @OA\Property(
     *      title="file_name",
     *      description="File name of file attachments",
     *      example="example.html",
     *      type="file",
     *       format="byte"
     * )
     *
     * @var string
     */

    public $file_name;
    /**
     * @OA\Property(
     *      title="file_uid",
     *      description="File File of file attachments",
     *      example=1
     * )
     *
     * @var integer
     */

    public $file_uid;
    /**
     * @OA\Property(
     *      title="target_id",
     *      description="Target  id of file attachments",
     *      example=1
     * )
     *
     * @var integer
     */

    public $target_id;
    /**
     * @OA\Property(
     *      title="target_type",
     *      description="Target  type of file attachments",
     *      example=1
     * )
     *
     * @var integer
     */

    public $target_type;

    /**
     * @OA\Property(
     *      title="created_by",
     *      description="Created by of file attachments",
     *      example=1
     * )
     *
     * @var integer
     */

    public $created_by;
    /**
     * @OA\Property(
     *      title="path",
     *      description="Path of file attachments",
     *      example=1
     * )
     *
     * @var integer
     */
    public $path;

    /**
     * @OA\Property(
     *      title="created_at",
     *      description="Created At of file attachments",
     *      example=1872600
     * )
     *
     * @var integer
     */

    public $created_at;
    /**
     * @OA\Property(
     *      title="updated_at",
     *      description="Updated At of file attachments",
     *      example=1872600
     * )
     *
     * @var integer
     */


    public $updated_at;
    /**
     * @OA\Property(
     *      title="updated_by",
     *      description="Updated at of file attachments",
     *      example=1872600
     * )
     *
     * @var integer
     */

    public $updated_by;

    protected $fillable = [
        'file_name',
        'file_uid',
        'target_id',
        'target_type',
        'created_by',
        'path',
        'created_at',
        'updated_at',
        'updated_by',
        'deleted_at',
        'path'
    ];
}
