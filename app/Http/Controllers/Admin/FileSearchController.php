<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

final class FileSearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $finder = (new Finder())->in($request->directory)->sortByModifiedTime();


        // Initialize empty arrays to hold the directories and files found in the directory
        $directories = [];
        $files = [];

        // Iterate over each item in the Finder results
        foreach ($finder as $item) {
            if (!Str::contains(Str::lower($item->getFilename()), Str::lower($request->term))) {
                continue;
            }

            // Create an array to hold the file info for the current item
            $fileInfo = [
                'basename' => $item->getBasename(),
                'type' => $item->getType(),
                'extension' => $item->getExtension(),
                'path' => $item->getPath(),
                'size' => $item->getSize(),
                'cTime' => $item->getCTime(),
                'aTime' => $item->getATime(),
                'mTime' => $item->getMTime(),
            ];

            // If the item is a directory, find its subdirectories and files
            if ($item->isDir()) {
                if (!Str::contains(Str::lower($item->getBasename()), Str::lower($request->term))) {
                    continue;
                }

                // Create a new Finder instance and set it to search the current directory
                $subFinder = new Finder();
                $subFinder->depth(0)->in($fileInfo['path'])->sortByModifiedTime();

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
            'path' => $request->directory,
            'directories' => $directories,
            'files' => $files,
            'currentDirectory' => basename($request->directory),
        ];

//        foreach ($files as $item) {
//            if ($item->isFile()) {
//                if (Str::contains(Str::lower($item->getFilename()), Str::lower($request->term))) {
//                    $filtersFiles[] = $item;
//                }
//            } else {
//                if (Str::contains(Str::lower($item->getBasename()), Str::lower($request->term))) {
//
//                    echo $item->getBasename();
//                }
//            }
//        }
    }
}
