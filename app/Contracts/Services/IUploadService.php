<?php

namespace App\Contracts\Services;

use Illuminate\Http\UploadedFile;

interface IUploadService
{
    public function handle(UploadedFile $file, string $directoryName = null);
}
