<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

final class ArchieveFileService
{
    public function renameFile($directory, $oldPath, $newPath)
    {
        $oldPath = $directory.DIRECTORY_SEPARATOR.$oldPath;
        $newPath = $directory.DIRECTORY_SEPARATOR.$newPath;

        if (! file_exists($oldPath)) {
            throw new \Exception('Old file path not found');
        }

        if (file_exists($newPath)) {
            throw new \Exception('New file path already exists');
        }

        $renamed = rename($oldPath, $newPath);

        if (! $renamed) {
            throw new \Exception('Failed to rename file');
        }

        return true;
    }

    public function uploadFile($directory, $file)
    {
        // Ensure that the directory exists
        Storage::makeDirectory($directory, 0777, true, true);

        // Generate a unique file name
        $fileName = uniqid().'.'.$file->getClientOriginalExtension();

        // Store the file in the specified directory
        Storage::putFileAs($directory, $file, $fileName);

        // Return the path to the uploaded file
        return $directory.DIRECTORY_SEPARATOR.$fileName;
    }

    public function removeFileOrDirectory($path)
    {
        if (Storage::exists($path)) {
            Storage::delete($path);

            return true;
        } else {
            throw new \Exception('File or directory not found');
        }
    }

    public function deleteFile($path)
    {
        $trashDirectory = storage_path('app/source/.trashed');
        $timestamp = time();
        $newPath = $trashDirectory.DIRECTORY_SEPARATOR.$timestamp.'_'.basename($path);
        if (file_exists($path)) {
            if (! file_exists($trashDirectory)) {
                mkdir($trashDirectory, 0777, true);
            }

            rename($path, $newPath);

            return $newPath;
        } else {
            throw new \Exception('File not found');
        }
    }

    public function copyFile($sourcePath, $destinationPath)
    {
        if (file_exists($sourcePath)) {
            copy($sourcePath, $destinationPath);

            return true;
        } else {
            throw new \Exception('Source file not found');
        }
    }
}
