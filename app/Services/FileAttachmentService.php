<?php

namespace App\Services;

use App\Models\FileAttachment;
use App\Repositories\FileAttachmentRepositoryInterface;
use App\Traits\GuzzleRequest;
use App\Exceptions\UploadFileException;

class FileAttachmentService
{
    use GuzzleRequest;

    public function __construct(
        protected FileAttachmentRepositoryInterface $repository
    ) {
        //
    }

    /**
     * Get all FileAttachment
     *
     * @param array $params
     * @return array
     */
    public function all(array $params): array
    {
        if (empty($params['target_id']) || empty($params['target_type'])) {
            return ["data" => []];
        }
        return $this->repository->findWhere([
            'target_id' => $params['target_id'],
            'target_type' => $params['target_type']
        ]);
    }

    /**
     * Create new file attachment
     *
     * @param array $params
     * @return array
     */
    public function create(array $params): array
    {
        if (empty($params['file'])) {
            return [];
        }
        $response = $this->makeRequest('POST', config('media-service.url.upload'), false, [
            'multipart' => [
                [
                    'name'     => 'file',
                    'contents' => file_get_contents($params['file']),
                    'filename' => $params['file']->getClientOriginalName()
                ],
                [
                    'name' => 'folder',
                    'contents' => FileAttachment::DEFAULT_FOLDER,
                ],
                [
                    'name' => 'user_id',
                    'contents' => auth()->user()->id,
                ],
            ]
        ]);

        if ($response->code != 200) {
            throw new UploadFileException("Upload file failed: " . $response->message);
        }

        return $this->repository->create([
            'file_name' => $this->formatAttachmentFileName($response->data->filename),
            'file_uid'  => $response->data->id,
            'path'      => config('media-service.url.domain') . '/' . $response->data->filename
        ]);
    }

    /**
     * Get file attachment by id
     *
     * @param integer $id
     * @return array
     */
    public function show(int $id): array
    {
        return $this->repository->find($id);
    }

    /**
     * @param string $fileName
     * @return string
     */
    private function formatAttachmentFileName(string $fileName): string
    {
        $paths = explode('/', $fileName);
        //get the last element of path
        return $paths[count($paths) - 1];
    }
}
