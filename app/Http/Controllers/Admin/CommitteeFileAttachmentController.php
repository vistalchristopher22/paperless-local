<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Resolvers\PDFLinkResolver;
use App\Utilities\FileUtility;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

final class CommitteeFileAttachmentController extends Controller
{
    public function show(string $file, string $location)
    {
        $path = FileUtility::fixTemporaryForwardSlashSeparator($location . DIRECTORY_SEPARATOR . $file);

        $outputDirectory = FileUtility::publicDirectoryForViewing();

        if (in_array(pathinfo($file, PATHINFO_BASENAME), FileUtility::CONVERTIBLE_FILE_EXTENSIONS)) {
            Artisan::call('convert:path "' . $path . '" --output="' . $outputDirectory . '"');
        } else {
            $path = Str::after($path, 'storage');
            $path = FileUtility::correctDirectorySeparator(base_path() . DIRECTORY_SEPARATOR . 'storage' . $path);
            FileUtility::copyFileToCommitteePublicDirectory($path, $outputDirectory . $file);
        }

        new PDFLinkResolver(FileUtility::publicDirectoryForViewing() . FileUtility::changeExtension($file));

        return view('admin.committee.file-displays.show-attachments', [
            'filePathForView' => FileUtility::generatePathForViewing($outputDirectory, $file),
        ]);
    }
}
