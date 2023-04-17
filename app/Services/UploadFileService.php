<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Contracts\Services\IUploadService;

final class UploadFileService implements IUploadService
{
    /**
     * If the file has a file, then create a filename with the current time, the original name of the
     * file, and store it in the public disk.
     *
     * @param UploadedFile file The name of the file input field in the form
     */
    public function handle(UploadedFile $file, string $directoryName = "committees")
    {
        $filename = time() . '_' .  $file->getClientOriginalName();
        Storage::disk('public')->putFileAs($directoryName, $file, $filename);
        return storage_path() . DIRECTORY_SEPARATOR . $directoryName . DIRECTORY_SEPARATOR . $filename;
    }
}
