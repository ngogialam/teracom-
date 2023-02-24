<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="File attachment create request",
 *      description="File attachment create request body data",
 *      type="object",
 *      required={"file_name"}
 * )
 *
 * @SuppressWarnings(PHPMD)
 */

class FileAttachmentCreateRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="file",
     *      description="File of file attachments",
     *      example="example.html",
     *      type="file",
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
     * )
     *
     * @var string
     */

    public $file_name;
    /**
     * @OA\Property(
     *      title="file_uid",
     *      description="File uid of file attachments",
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
     *      description="Updated At of file attachments",
     *      example=1872600
     * )
     *
     * @var integer
     */

    public $updated_by;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'file' => 'required',
            'file_uid' => 'sometimes',
            'target_id' => 'sometimes',
            'target_type' => 'sometimes',
        ];
    }
}
