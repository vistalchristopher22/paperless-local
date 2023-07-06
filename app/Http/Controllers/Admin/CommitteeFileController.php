<?php

namespace App\Http\Controllers\Admin;

use App\Models\Committee;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Utilities\CommitteeFileUtility;
use Illuminate\Support\Facades\Artisan;

final class CommitteeFileController extends Controller
{
    public function __construct()
    {
        Cache::flush();
    }

    public function show(int $committee)
    {
        $committee = Committee::find($committee, ['id', 'file_path']);
        $filePath = CommitteeFileUtility::correctDirectorySeparator($committee->file_path);
        $fileName = basename($filePath);
        $outputDirectory = CommitteeFileUtility::publicDirectoryForViewing();
        Artisan::call("convert:path \"" . $filePath . "\" --output=\"" . $outputDirectory . "\"");
        $pathForView = CommitteeFileUtility::generatePathForViewing($outputDirectory, $fileName);
        $basePath = base_path();
        $escaped_path = escapeshellarg(CommitteeFileUtility::publicDirectoryForViewing() .  CommitteeFileUtility::changeExtension($fileName));
        shell_exec("python.exe $basePath\\reader.py -f $escaped_path");
        return view('admin.committee.show', [
            'filePathForView' => $pathForView,
        ]);
    }


    public function edit(Committee $committee_file)
    {
        return $committee_file;
    }
}
