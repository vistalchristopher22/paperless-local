<?php

namespace App\Utilities;

use Error;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class FileUtility
{
    public const CONVERTIBLE_FILE_EXTENSIONS = [
        'doc', 'docx', 'webp', 'txt',
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

    public static function generatePathForViewing(string $outputDirectory, string $fileName): string
    {
        $fullDirectory = $outputDirectory . self::changeExtension($fileName);

        return Str::of($fullDirectory)
            ->remove(self::correctDirectorySeparator(public_path()), $fullDirectory)
            ->start('/');
    }

    public static function changeExtension(string $fileName): string
    {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);

        return Str::replace($extension, self::EXTENSION_REPLACE[$extension], $fileName);
    }

    public static function correctDirectorySeparator(string $path): string
    {
        return Str::replace(search: '//', replace: '/', subject: Str::replace(search: '\\', replace: '/', subject: $path));
    }

    public static function reverseFileExtension(string $fileName): string
    {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);

        return Str::replace($extension, Str::reverse($extension), $fileName);
    }


    public static function publicDirectoryForViewing(): string
    {
        return self::correctDirectorySeparator(public_path() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'committees' . DIRECTORY_SEPARATOR);
    }

    public static function temporaryReplaceForwardSlash(string $path): string
    {
        return Str::of($path)->replace(['/', '\\'], '||', $path)
            ->value();
    }

    public static function fixTemporaryForwardSlashSeparator(string $path): string
    {
        return Str::of($path)->replace('||', '/', $path)
            ->remove('https://paperless.test/custom/attachment')
            ->prepend(base_path())
            ->replace('\\', '/')
            ->value();
    }

    public static function draftCommitteesDirectory(): string
    {
        return self::correctDirectorySeparator(Storage::disk('DRAFT_COMMITTEES')->path('/'));
    }

    public static function copyFileToCommitteePublicDirectory(string $originalSource, string $destinationSource): void
    {
        copy($originalSource, $destinationSource);
    }

    public static function isInputDirectoryEscaped(string $path): string
    {
        $escaped_string = escapeshellarg($path);

        if ($path === stripslashes($escaped_string)) {
            return escapeshellarg($path);
        }
        return $path;
    }

    public static function addTimePrefixToFileName(string &$filename): string
    {
        $timePrefixRegex = '/^\d{10}_/';

        if (!preg_match($timePrefixRegex, $filename)) {
            $filename = time() . '_' . $filename;
        }

        return $filename;
    }

    public static function secureName(string $name): string
    {
        return Str::of($name)->headline()->replace([" ", "/", "\\"], "_")->upper();
    }


    public static function hideFile(string $path)
    {
        if (is_null($path)) {
            throw new Exception("Directory must have a value!");
        }

        $fileName = basename($path);

        return Str::replace($fileName, "." . $fileName, $path);
    }


    public function isPDF(string $file_path): bool
    {
        $fileExtension = pathinfo($file_path, PATHINFO_EXTENSION);

        return Str::upper($fileExtension) === 'PDF';
    }


    public static function generateDirectory(string $path): string
    {
        if (!file_exists($path)) {
            if (!mkdir($path, 0777, true) && !is_dir($path)) {
                throw new Error(sprintf('Directory "%s" was not created', $path));
            }
        }

        return $path;
    }

    public static function generateDirectories(array $paths = []): array
    {
        foreach ($paths as $directory) {
            if (!file_exists($directory)) {
                if (!mkdir(Str::upper($directory), 0777, true) && !is_dir($directory)) {
                    throw new Error(sprintf('Directory "%s" was not created', $directory));
                }

                if (str_ends_with($directory, '.tmp')) {
                    touch($directory);
                }
            }
        }
        return $paths;
    }
}
