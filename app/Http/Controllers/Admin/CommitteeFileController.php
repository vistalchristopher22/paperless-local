<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Committee;
use App\Resolvers\PDFLinkResolver;
use App\Utilities\FileUtility;
use Illuminate\Support\Facades\Artisan;

final class CommitteeFileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'features:administrator'])->only('edit');
    }

    public function show(int $committee)
    {
        $committee = Committee::find($committee, ['id', 'file_path']);

        $filePath = FileUtility::correctDirectorySeparator($committee->file_path);

        $fileName = basename($filePath);

        $outputDirectory = FileUtility::publicDirectoryForViewing();

        Artisan::call('convert:path "' . $filePath . '" --output="' . $outputDirectory . '"');

        $pathForView = FileUtility::generatePathForViewing($outputDirectory, $fileName);

        new PDFLinkResolver(FileUtility::publicDirectoryForViewing() . FileUtility::changeExtension($fileName));

        return view('admin.committee.file-displays.show', [
            'filePathForView' => $pathForView,
        ]);
    }


    public function edit(Committee $committee_file)
    {
        return $committee_file;
    }
}
