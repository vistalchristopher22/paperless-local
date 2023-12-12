<?php

namespace App\Services;

use App\Contracts\Services\IUploadService;
use Illuminate\Http\Request;

final class CommitteeService
{
    public function uploadFile(Request $request, IUploadService $uploadService): array
    {
        if ($request->has('file') && $request->file('file') != null) {
            $path = $uploadService->handle($request->file('file'), 'DRAFT COMMITTEES');
            $request->merge(['file_path' => $path]);
        }

        return $request->all();
    }
}
