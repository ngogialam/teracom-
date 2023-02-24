<?php

namespace App\Services;

use App\Repositories\ProcessChangeLogRepositoryInterface;
use Carbon\Carbon;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Str;

class ProcessChangeLogService
{
    public function __construct(
        protected ProcessChangeLogRepositoryInterface $repository
    ) {
        //
    }

    /**
     * Get alll process change log
     *
     * @param array $request
     * @return array
     */
    public function all(array $request): array
    {
        $limit = !empty($request['limit']) ? $request['limit'] : BaseController::DEFAULT_LIMIT;
        $page = !empty($request['page']) ? $request['page'] : BaseController::DEFAULT_PAGE;
        $arrProcessChangeLog = [];
        if (empty($request['process_id'])) {
            return ["list" => [], "limit" => $limit, "page" => $page];
        }
        $processChangeLog = $this->repository->where('process_id', $request['process_id'])
            ->orderBy('id', 'asc')
            ->skip(($page - 1) * $limit)
            ->take($limit)
            ->get();
        $arrProcessChangeLog['list'] = $processChangeLog;
        $arrProcessChangeLog['limit'] = $limit;
        $arrProcessChangeLog['page'] = $page;
        return $arrProcessChangeLog;
    }

    /**
     * delete process change log
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->repository->update([
            'deleted_at' => Carbon::now()->timestamp
        ], $id);
    }
}
