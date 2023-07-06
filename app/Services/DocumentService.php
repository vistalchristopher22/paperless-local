<?php

namespace App\Services;

use Illuminate\Support\Str;

final class DocumentService
{
    public function isPDF(string $file_path): bool
    {
        $fileExtension = pathinfo($file_path, PATHINFO_EXTENSION);

        return Str::upper($fileExtension) === 'PDF';
    }
}
