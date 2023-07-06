<?php

namespace App\Services;

use App\Contracts\Services\IUploadService;
use Illuminate\Http\Request;

final class CommitteeService
{
    /**
     * If the request has a file, then upload the file and merge the file path into the request
     *
     * @param Request request The request object
     * @param IUploadService uploadService This is the service that will handle the upload.
     */
    public function uploadFile(Request $request, IUploadService $uploadService): mixed
    {
        if ($request->has('file')) {
            $path = $uploadService->handle($request->file('file'), 'DRAFT COMMITTEES');
            $request->merge(['file_path' => $path]);
        }

        return $request->all();
    }
}
