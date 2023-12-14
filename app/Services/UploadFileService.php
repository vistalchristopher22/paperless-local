<?php

namespace App\Services;

use App\Contracts\Services\IUploadService;
use App\Utilities\FileUtility;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class UploadFileService implements IUploadService
{
    public function handle(UploadedFile $file, string $directoryName = null): string
    {
        $extension = $file->getClientOriginalExtension();

        $filename = $file->getClientOriginalName();

        $filename = FileUtility::addTimePrefixToFileName($filename);

        $filename = Str::of($filename)
            ->replace(" ", FileUtility::FILE_SEPARATOR)
            ->substr(0, - (strlen($extension)))
            ->upper()
            ->append($extension)
            ->value();

        $directoryName = Str::of($directoryName)->replace(" ", FileUtility::FILE_SEPARATOR)->upper()->value();

        $directory = Storage::disk('source')->putFileAs($directoryName, $file, $filename);
        return Storage::disk('source')->path($directory);
    }
}
