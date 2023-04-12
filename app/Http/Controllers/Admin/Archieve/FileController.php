<?php

namespace App\Http\Controllers\Admin\Archieve;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\Finder\Finder;
use App\Services\ArchieveFileService;

final class FileController extends Controller
{
    public function __construct(private ArchieveFileService $archieveFileService)
    {
    }

    public function index()
    {
        $finder = new Finder();
        $finder->directories()->depth(0)->in(storage_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'source')->sortByModifiedTime();

        $directories = [];

        foreach ($finder as $directory) {
            $directories[] = [
                'basename' => $directory->getBasename(),
                'type' => $directory->getType(),
                'extension' => $directory->getExtension(),
                'path' => $directory->getRealPath(),
                'size' => $directory->getSize(),
                'cTime' => $directory->getCTime(),
                'aTime' => $directory->getATime(),
                'mTime' => $directory->getMTime(),
            ];
        }

        return view('admin.archieve.files.index', [
            'directories' => $directories,
        ]);
    }

    public function getFiles(Request $request)
    {
        $finder = new Finder();


        $finder->depth(0)->in($request->path)->sortByModifiedTime();

        $filesInFolder = [];

        foreach ($finder as $files) {
            $filesInFolder[] = [
                'basename' => $files->getBasename(),
                'path' => $files->getRealPath(),
                'size' => $files->getSize(),
                'cTime' => $files->getCTime(),
                'aTime' => $files->getATime(),
                'mTime' => $files->getMTime(),
                'type' => $files->getType(),
                'extension' => $files->getExtension(),
            ];
        }


        return $filesInFolder;
    }
}
