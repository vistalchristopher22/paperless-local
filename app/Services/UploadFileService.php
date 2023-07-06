<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Contracts\Services\IUploadService;

final class UploadFileService implements IUploadService
{
    public function handle(UploadedFile $file, string $directoryName = null)
    {
        $filename = time() . '_' .  $file->getClientOriginalName();
        $directoryName = str_replace(" ", "_", $directoryName);
        $directory = Storage::disk('source')->putFileAs($directoryName, $file, $filename);
        return Storage::disk('source')->path($directory);
    }
}
