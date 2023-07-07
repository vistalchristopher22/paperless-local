<?php

namespace App\Services;

use App\Contracts\Services\IUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class UploadImageService implements IUploadService
{
    /**
     * This function takes an uploaded file, creates a unique filename, and then stores the file in the
     * public disk.
     *
     * @param UploadedFile file The file that was uploaded.
     * @return The filename of the image.
     */
    public function handle(UploadedFile $file, string $directoryName = null)
    {
        // $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $filename = uniqid().'.'.$file->getClientOriginalName();

        Storage::disk('public')->putFileAs('user-images', $file, $filename);

        return $filename;
    }
}
