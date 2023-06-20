<?php

namespace App\Http\Controllers\Admin;

use App\Models\Committee;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class CommitteeFileController extends Controller
{
    public function show(Committee $committee_file)
    {
        $file = basename($committee_file->file_path);
        // build a path for this committee

        $fullPath = public_path("storage/committees/{$file}");
        $filePathForView = "storage" . DIRECTORY_SEPARATOR . "committees" . DIRECTORY_SEPARATOR . $file;

        $filePath = str_replace("\\", "/", $fullPath);
        Artisan::call("convert:path \"" . $filePath . "\"");
        // Artisan::call("convert:path " . str_replace("\\", "/", $fullPath));

        $extension = pathinfo($file, PATHINFO_EXTENSION);

        $newFilename = str_replace($extension, 'pdf', $file);

        $filePathForView = str_replace($file, $newFilename, $filePathForView);

        return view('admin.committee.show', compact('filePathForView'));
    }


    public function edit(Committee $committee_file)
    {
        return $committee_file;
    }
}
