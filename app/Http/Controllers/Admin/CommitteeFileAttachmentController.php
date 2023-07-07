<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Resolvers\PDFLinkResolver;
use App\Utilities\CommitteeFileUtility;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

final class CommitteeFileAttachmentController extends Controller
{
    public function show(string $file, string $location)
    {
        $path = CommitteeFileUtility::fixTemporaryForwardSlashSeparator($location . DIRECTORY_SEPARATOR . $file);

        $outputDirectory = CommitteeFileUtility::publicDirectoryForViewing();

        if (in_array(pathinfo($file, PATHINFO_BASENAME), CommitteeFileUtility::CONVERTIBLE_FILE_EXTENSIONS)) {
            Artisan::call('convert:path "' . $path . '" --output="' . $outputDirectory . '"');
        } else {
            $path = Str::after($path, 'storage');
            $path = CommitteeFileUtility::correctDirectorySeparator(base_path() . DIRECTORY_SEPARATOR . 'storage' . $path);
            CommitteeFileUtility::copyFileToCommitteePublicDirectory($path, $outputDirectory . $file);
        }

        new PDFLinkResolver(CommitteeFileUtility::publicDirectoryForViewing() . CommitteeFileUtility::changeExtension($file));

        return view('admin.committee.file-displays.show-attachments', [
            'filePathForView' => CommitteeFileUtility::generatePathForViewing($outputDirectory, $file),
        ]);
    }
}
