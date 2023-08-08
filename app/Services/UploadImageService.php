<?php

namespace App\Services;

use App\Contracts\Services\IUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class UploadImageService implements IUploadService
{
    public function handle(UploadedFile $file, string $directoryName = null): string
    {
        $filename = uniqid() . '.' . $file->getClientOriginalName();

        Storage::disk('public')->putFileAs('user-images', $file, $filename);

        return $filename;
    }
}
