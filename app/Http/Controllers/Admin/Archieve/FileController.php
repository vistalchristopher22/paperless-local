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
        return view('admin.archieve.files.index', [
            'source' => storage_path('app/source'),
        ]);
    }

    public function getFileByTypes(Request $request)
    {
        $fileTypes =  [
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
                '*.csv'
            ],
            'powerpoint_file' => [
                '*.ppt',
                '*.pptx',
                '*.odp'
            ],
            'pictures_file' => [
                '*.jpg',
                '*.jpeg',
                '*.png',
                '*.gif',
                '*.bmp',
                '*.tif',
                '*.tiff'
            ],
            'pdf_file' => [
                '*.pdf'
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
                '*'
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
                '*.wma'
            ],
            'archives_file' => [
                '*.zip',
                '*.rar',
                '*.7z',
                '*.tar'
            ],
        ];

        $finder = new Finder();

        if ($request->type == 'folder') {
            $finder = new Finder();
            $directories = iterator_to_array($finder->in($request->directory)->directories());

            $rootDirectories = [];
            $rootFiles = [];

            foreach ($finder as $item) {
                $itemData = [
                    'basename' => $item->getBasename(),
                    'type' => $item->getType(),
                    'extension' => $item->getExtension(),
                    'path' => $item->getRealPath(),
                    'size' => $item->getSize(),
                    'cTime' => $item->getCTime(),
                    'aTime' => $item->getATime(),
                    'mTime' => $item->getMTime(),
                ];

                if ($item->isDir()) {
                    $subDirectories = [];
                    $subFiles = [];

                    $subFinder = new Finder();
                    $subFinder->depth('== 0')->in($itemData['path'])->sortByModifiedTime();

                    foreach ($subFinder as $subItem) {
                        $subItemData = [
                            'basename' => $subItem->getBasename(),
                            'type' => $subItem->getType(),
                            'extension' => $subItem->getExtension(),
                            'path' => $subItem->getRealPath(),
                            'size' => $subItem->getSize(),
                            'cTime' => $subItem->getCTime(),
                            'aTime' => $subItem->getATime(),
                            'mTime' => $subItem->getMTime(),
                        ];

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

            return response()->json([
                'path' => $request->directory,
                'directories' => $rootDirectories,
                'files' => $rootFiles,
                'currentDirectory' => basename($request->directory),
            ]);
        } else {
            $types = $fileTypes[$request->type];

            $files = $finder->in($request->directory)
                ->files()
                ->name($types)
                ->sortByModifiedTime();

            $files = iterator_to_array($files);
            $filteredFiles = [];
            foreach ($files as $item) {
                $filteredFiles[] = [
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

            return response()->json([
                'path' => $request->directory,
                'directories' => [],
                'files' => $filteredFiles,
                'currentDirectory' => basename($request->directory),
            ]);
        }
    }

    public function getFileInformation(Request $request)
    {
        $finder = new Finder();
        $fileName = basename($request->path);
        $finderFile = iterator_to_array($finder->files()->in($request->directory));

        $filteredFiles = array_filter($finderFile, function ($file) use ($fileName) {
            return $file->getFilename() === $fileName;
        });

        if (empty($filteredFiles)) {
            return response()->json(['error' => 'File not found']);
        }

        $file = reset($filteredFiles);

        $data = [
            'name' => $request->path,
            'type' => $file->getExtension(),
            'size' => $this->formatSizeUnits($file->getSize()),
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
            'directory' => $request->directory,
        ];

        return response()->json($data);
    }

    private function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    public function getFiles(Request $request)
    {
        $path = $request->query('path');

        $finder = new Finder();
        $finder->depth('== 0')->in($path)->sortByModifiedTime();

        $directories = [];
        $files = [];

        foreach ($finder as $item) {
            $itemData = [
                'basename' => $item->getBasename(),
                'type' => $item->getType(),
                'extension' => $item->getExtension(),
                'path' => $item->getRealPath(),
                'size' => $item->getSize(),
                'cTime' => $item->getCTime(),
                'aTime' => $item->getATime(),
                'mTime' => $item->getMTime(),
            ];

            if ($item->isDir()) {
                $subFinder = new Finder();
                $subFinder->depth('== 0')->in($itemData['path'])->sortByModifiedTime();

                $subDirectories = [];
                $subFiles = [];

                foreach ($subFinder as $subItem) {
                    $subItemData = [
                        'basename' => $subItem->getBasename(),
                        'type' => $subItem->getType(),
                        'extension' => $subItem->getExtension(),
                        'path' => $subItem->getRealPath(),
                        'size' => $subItem->getSize(),
                        'cTime' => $subItem->getCTime(),
                        'aTime' => $subItem->getATime(),
                        'mTime' => $subItem->getMTime(),
                    ];

                    if ($subItem->isDir()) {
                        $subDirectories[] = $subItemData;
                    } else {
                        $subFiles[] = $subItemData;
                    }
                }

                $itemData['directories'] = $subDirectories;
                $itemData['files'] = $subFiles;

                $directories[] = $itemData;
            } else {
                $files[] = $itemData;
            }
        }


        return response()->json([
            'path' => $path,
            'directories' => $directories,
            'files' => $files,
            'currentDirectory' => basename($path),
        ]);
    }

    public function renameFile(Request $request)
    {

        try {
            $this->archieveFileService->renameFile($request->directory, $request->oldName, $request->newName);
            $response = ['message' => 'File renamed successfully'];
            $code = 200;
        } catch (\Exception $e) {
            $response = ['message' => $e->getMessage()];
            $code = 422;
        }
        return response()->json($response, $code);
    }

    public function upload(Request $request)
    {
        try {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('source', $filename);
            $filePath = storage_path('app/source/' . $filename);
            $mTime = filemtime($filePath);
            $fileSize = filesize($filePath);
            $response = [
                'message' => 'File uploaded successfully',
                'path' => storage_path('app/source/'),
                'fileName' => $filename,
                'mTime' => $mTime,
                'fileSize' => $fileSize
            ];
            $code = 200;
        } catch (\Exception $e) {
            $response = ['message' => $e->getMessage()];
            $code = 422;
        }

        return response()->json($response, $code);
    }

    public function deleteFile(Request $request)
    {
        $path = $request->directory . DIRECTORY_SEPARATOR . $request->path;
        try {
            $this->archieveFileService->deleteFile($path);
            $response = ['message' => 'File deleted successfully'];
            $code = 200;
        } catch (\Exception $e) {
            $response = ['message' => $e->getMessage()];
            $code = 422;
        }

        return response()->json($response, $code);
    }

    public function deleteBulk(Request $request)
    {
        $data = array_filter($request->all());
        foreach ($data as $file) {
            $path = $file['directory'] . DIRECTORY_SEPARATOR . $file['name'];
            $this->archieveFileService->deleteFile($path);
        }

        return response()->json(['message' => 'All files deleted successfully!']);
    }

    public function preview(Request $request)
    {
        $currentDirectory = $request->path . DIRECTORY_SEPARATOR . $request->fileName;
        $destination  = public_path("storage/previews/{$request->fileName}");

        try {
            $this->archieveFileService->copyFile($currentDirectory, $destination);
            $response = ['message' => 'File copied successfully', 'destination' =>  url('/') . "/storage/previews/{$request->fileName}"];
            $code = 200;
        } catch (\Exception $e) {
            $response = ['message' => $e->getMessage()];
            $code = 422;
        }

        return response()->json($response, $code);
    }

    public function show(Request $request)
    {
        $path = $request->directory . DIRECTORY_SEPARATOR . $request->name;
        $basePath = base_path();
        $escaped_path = escapeshellarg($path);
        shell_exec("python.exe $basePath\\explorer.py $escaped_path");
        return response()->json(['success' => true]);
    }
}
