<?php

namespace App\Services;

use Exception;
use Symfony\Component\Finder\Finder;
use Illuminate\Support\Facades\Storage;

final class ArchiveFileService
{
    public const FILE_TYPES = [
        'word_file' => [
            '*.doc',
            '*.docx',
            '*.odt',
            '*.rtf',
            '*.txt',
        ],
        'excel_file' => [
            '*.xls',
            '*.xlsx',
            '*.ods',
            '*.csv',
        ],
        'powerpoint_file' => [
            '*.ppt',
            '*.pptx',
            '*.odp',
        ],
        'pictures_file' => [
            '*.jpg',
            '*.jpeg',
            '*.png',
            '*.gif',
            '*.bmp',
            '*.tif',
            '*.tiff',
        ],
        'pdf_file' => [
            '*.pdf',
        ],
        'video_file' => [
            '*.mp4',
            '*.avi',
            '*.mov',
            '*.wmv',
            '*.flv',
            '*.mkv',
            '*.mpeg',
        ],
        'folder_file' => [
            '*',
        ],
        'shortcut_file' => [
            '*.lnk',
        ],
        'audio_file' => [
            '*.mp3',
            '*.wav',
            '*.aac',
            '*.flac',
            '*.ogg',
            '*.wma',
        ],
        'archives_file' => [
            '*.zip',
            '*.rar',
            '*.7z',
            '*.tar',
        ],
    ];

    public function getFilesByType(string $type, string $directory)
    {
        if ($type === 'folder') {
            return $this->getFolderContents($directory);
        }

        $types = self::FILE_TYPES[$type];

        $files = (new Finder())->in($directory)
            ->files()
            ->name($types)
            ->sortByModifiedTime();

        $filteredFiles = [];
        foreach ($files as $item) {
            $filteredFiles[] = $this->getFileInformation($item);
        }

        return [
            'path' => $directory,
            'directories' => [],
            'files' => $filteredFiles,
            'currentDirectory' => basename($directory),
        ];
    }

    protected function getFolderContents(string $directory)
    {
        $finder = (new Finder())->in($directory)->directories();

        $rootDirectories = [];
        $rootFiles = [];

        foreach ($finder as $item) {
            $itemData = $this->getFileInformation($item);

            if ($item->isDir()) {
                $subDirectories = [];
                $subFiles = [];

                $subFinder = (new Finder())->depth('== 0')->in($itemData['path'])->sortByModifiedTime();

                foreach ($subFinder as $subItem) {
                    $subItemData = $this->getFileInformation($subItem);

                    if ($subItem->isDir()) {
                        $subDirectories[] = $subItemData;
                    } else {
                        $subFiles[] = $subItemData;
                    }
                }

                $itemData['directories'] = $subDirectories;
                $itemData['files'] = $subFiles;

                $rootDirectories[] = $itemData;
            } else {
                $rootFiles[] = $itemData;
            }
        }

        return [
            'path' => $directory,
            'directories' => $rootDirectories,
            'files' => $rootFiles,
            'currentDirectory' => basename($directory),
        ];
    }

    protected function getFileInformation($item)
    {
        return [
            'basename' => $item->getBasename(),
            'type' => $item->getType(),
            'extension' => $item->getExtension(),
            'path' => $item->getRealPath(),
            'size' => $item->getSize(),
            'cTime' => $item->getCTime(),
            'aTime' => $item->getATime(),
            'mTime' => $item->getMTime(),
            'directory' => dirname($item->getRealPath()),
        ];
    }

    public function getFileInDirectory(string $directoryPath)
    {
        // Create a new Finder instance and set it to search the given directory path
        $finder = new Finder();
        $finder->depth(0)->in($directoryPath)->sortByModifiedTime();

        // Initialize empty arrays to hold the directories and files found in the directory
        $directories = [];
        $files = [];

        // Iterate over each item in the Finder results
        foreach ($finder as $item) {
            // Create an array to hold the file info for the current item
            $fileInfo = [
                'basename' => $item->getBasename(),
                'type' => $item->getType(),
                'extension' => $item->getExtension(),
                'path' => $item->getRealPath(),
                'size' => $item->getSize(),
                'cTime' => $item->getCTime(),
                'aTime' => $item->getATime(),
                'mTime' => $item->getMTime(),
            ];

            // If the item is a directory, find its subdirectories and files
            if ($item->isDir()) {
                // Create a new Finder instance and set it to search the current directory
                $subFinder = new Finder();
                $subFinder->depth('== 0')->in($fileInfo['path'])->sortByModifiedTime();

                // Initialize empty arrays to hold the subdirectories and files found in the current directory
                $subDirectories = [];
                $subFiles = [];

                // Iterate over each item in the subFinder results
                foreach ($subFinder as $subItem) {
                    // Create an array to hold the file info for the current subitem
                    $subFileInfo = [
                        'basename' => $subItem->getBasename(),
                        'type' => $subItem->getType(),
                        'extension' => $subItem->getExtension(),
                        'path' => $subItem->getRealPath(),
                        'size' => $subItem->getSize(),
                        'cTime' => $subItem->getCTime(),
                        'aTime' => $subItem->getATime(),
                        'mTime' => $subItem->getMTime(),
                    ];

                    // If the subitem is a directory, add it to the subdirectories array. Otherwise, add it to the subfiles array.
                    if ($subItem->isDir()) {
                        $subDirectories[] = $subFileInfo;
                    } else {
                        $subFiles[] = $subFileInfo;
                    }
                }

                // Add the subdirectories and subfiles arrays to the file info for the current directory
                $fileInfo['directories'] = $subDirectories;
                $fileInfo['files'] = $subFiles;

                // Add the file info for the current item to the directories array
                $directories[] = $fileInfo;
            } else {
                // If the item is a file, add it to the files array
                $files[] = $fileInfo;
            }
        }

        // Return an array containing the directory path, directories, files, and current directory name
        return [
            'path' => $directoryPath,
            'directories' => $directories,
            'files' => $files,
            'currentDirectory' => basename($directoryPath),
        ];
    }

    public function getFileDetails(string $directory, string $fileName)
    {
        $finder = new Finder();
        $finderFile = iterator_to_array($finder->files()->in($directory));

        $filteredFiles = array_filter($finderFile, function ($file) use ($fileName) {
            return $file->getFilename() === $fileName;
        });

        if (empty($filteredFiles)) {
            return null;
        }

        $file = reset($filteredFiles);

        return [
            'name' => $fileName,
            'type' => $file->getExtension(),
            'size' => formatSizeUnits($file->getSize()),
            'inode' => $file->getInode(),
            'perms' => substr(sprintf('%o', $file->getPerms()), -4),
            'owner' => $file->getOwner(),
            'group' => $file->getGroup(),
            'atime' => date('M d, Y H:i A', $file->getATime()),
            'mtime' => date('M d, Y H:i A', $file->getMTime()),
            'ctime' => date('M d, Y H:i A', $file->getCTime()),
            'link_count' => $file->isLink() ? 1 : ($file->getLinkTarget() ? 2 : 1),
            'uid' => $file->getOwner(),
            'gid' => $file->getGroup(),
            'symlink' => $file->isLink(),
            'directory' => $directory,
        ];
    }

    public function rename($directory, $oldPath, $newPath): bool
    {
        $oldPath = $directory . DIRECTORY_SEPARATOR . $oldPath;
        $newPath = $directory . DIRECTORY_SEPARATOR . $newPath;

        if (!file_exists($oldPath)) {
            throw new Exception('Old file path not found');
        }

        if (file_exists($newPath)) {
            throw new Exception('New file path already exists');
        }

        $renamed = rename($oldPath, $newPath);

        if (!$renamed) {
            throw new Exception('Failed to rename file');
        }

        return true;
    }

    public function uploadFile($directory, $file): string
    {
        Storage::makeDirectory($directory, 0777, true, true);
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        Storage::putFileAs($directory, $file, $fileName);
        return $directory . DIRECTORY_SEPARATOR . $fileName;
    }

    public function delete(string $path): string
    {
        $trashDirectory = Storage::disk('SOURCE_TRASHED')->path('/');
        $timestamp = time();
        $newPath = $trashDirectory . DIRECTORY_SEPARATOR . $timestamp . '_' . basename($path);

        if (!file_exists($path)) {
            throw new Exception('File not found');
        }

        if (!file_exists($trashDirectory)) {
            mkdir($trashDirectory, 0777, true);
        }

        if (rename($path, $newPath)) {
            return $newPath;
        }

        throw new Exception('Failed to move file to trash');
    }

    public function copy($sourcePath, $destinationPath): bool
    {
        if (file_exists($sourcePath)) {
            copy($sourcePath, $destinationPath);
            return true;
        }
        throw new Exception('Source file not found');
    }
}
