<?php

namespace App\Contracts\Services;

use Illuminate\Http\UploadedFile;

interface IUploadImageService
{
    public function handle(UploadedFile $file);
}
