<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Contracts\Services\IUploadService;

final class UploadImageService implements IUploadService
{
    /**
     * This function takes an uploaded file, creates a unique filename, and then stores the file in the
     * public disk.
     *
     * @param UploadedFile file The file that was uploaded.
     *
     * @return The filename of the image.
     */
    public function handle(UploadedFile $file)
    {
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();

        Storage::disk('public')->putFileAs('user-images', $file, $filename);
        return $filename;
    }
}
