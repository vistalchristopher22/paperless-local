<?php

namespace App\Utilities;

use Illuminate\Support\Str;

final class CommitteeFileUtility
{
    public const CONVERTIBLE_FILE_EXTENSIONS = [
        'doc', 'docx', 'webp', 'txt'
    ];

    public const EXTENSION_REPLACE = [
        'docx' => 'pdf',
        'doc' => 'pdf',
        'pdf' => 'pdf',
    ];

    public const REVERSED_EXTENSION_CONVERT = [
        'xcod' => 'pdf',
        'cod' => 'pdf',
    ];

    public static function changeExtension(string $fileName): string
    {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        return Str::replace($extension, self::EXTENSION_REPLACE[$extension], $fileName);
    }

    public static function generatePathForViewing(string $outputDirectory, string $fileName): string
    {
        $fullDirectory = $outputDirectory . static::changeExtension($fileName);
        return Str::of($fullDirectory)
            ->remove(static::correctDirectorySeparator(public_path()), $fullDirectory)
            ->start('/');
    }

    public static function publicDirectoryForViewing(): string
    {
        return static::correctDirectorySeparator(public_path() . DIRECTORY_SEPARATOR . "storage" . DIRECTORY_SEPARATOR . "committees" . DIRECTORY_SEPARATOR);
    }

    public static function reverseFileExtension(string $fileName): string
    {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        return Str::replace($extension, Str::reverse($extension), $fileName);
    }

    public static function correctDirectorySeparator(string $path): string
    {
        return Str::replace("\\", "/", $path);
    }

    public static function isExists(string $file): bool
    {
        return file_exists(CommitteeFileUtility::publicDirectoryForViewing() . CommitteeFileUtility::changeExtension($file));
    }

    public static function temporaryReplaceForwardSlash(string $path): string
    {
        return Str::of($path)->replace(["/", "\\"], "||", $path)
            ->value();
    }

    public static function fixTemporaryForwardSlashSeparator(string $path): string
    {
        return Str::of($path)->replace("||", "/", $path)
            ->remove("https://paperless.test/custom/attachment")
            ->prepend(base_path())
            ->replace("\\", "/")
            ->value();
    }
}
