<?php

namespace App\Http\Controllers\Admin;

use App\Models\Committee;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class CommitteeFileController extends Controller
{
    public function show(Committee $committee_file)
    {
        $originalFile = str_replace("storage", "public\storage", $committee_file->file_path);
        $file = str_replace("\\", "\\\\", $originalFile);
        Artisan::call('convert:path ' . $file);

        $newFile = str_replace("\\public\\", "", $file);
        $newFile = str_replace(".docx", ".pdf", $newFile);
        $filePathForView = str_replace(str_replace("\\", "\\\\", dirname(app_path())), "", $newFile);
        $filePathForView = Str::replaceFirst("\\\\", '', $filePathForView);

        return view('admin.committee.show', [
            'filePathForView' => $filePathForView,
        ]);
    }


    public function edit(Committee $committee_file)
    {
        return $committee_file;
    }
}
