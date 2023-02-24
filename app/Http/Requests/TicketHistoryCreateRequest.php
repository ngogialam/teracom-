<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Ticket History",
 *      description="Ticket History",
 *      required={"id","ticket_req_id","approval_status","approval_comments","created_at","updated_at","deleted_at","created_by", "updated_by","name"},
 *      type="array",
 *      required={"id","ticket_req_id","approval_status","approval_comments","created_at","updated_at","deleted_at","created_by", "updated_by","name"},
 *         example={
 *              {
 *                      "id": 1,
     *                  "ticket_req_id":1,
     *                  "approval_status":1,
     *                  "approval_comments":"hahah hog cos gi",
     *                  "created_at": 22,
     *                  "updated_at": 22,
     *                  "deleted_at":99,
     *                  "created_by": 1,
     *                  "updated_by": 1,
     *                  "name": "gggghh",
     *
     *                }, {
     *                  "id": 2,
     *                  "ticket_req_id":2,
     *                  "approval_status":0,
     *                  "approval_comments":"hahah hog cos gi dau",
     *                  "created_at": 32,
     *                  "updated_at": 32,
     *                  "deleted_at":99,
     *                  "created_by": 3,
     *                  "updated_by": 2,
     *                  "name": "ghh",
 *          }
 * },
 *      @OA\Items()
 * )
 *
 * @SuppressWarnings(PHPMD)
 */

class TicketHistoryCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }
    public $approval_status;
    /**
     * @OA\Property(
     *      title="ticket_request_id",
     *      description="Ticket id type of step object",
     *      example=1,
     *      enum={"0 bản nháp", "1: chờ phê duyệt/gửi đi"," 2: phê duyệt", "3: từ chối"}
     * )
     *
     * @var int
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
