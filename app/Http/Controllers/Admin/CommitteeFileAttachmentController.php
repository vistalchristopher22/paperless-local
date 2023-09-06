<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Utilities\FileUtility;

final class CommitteeFileAttachmentController extends Controller
{
    public function show(string $file, string $location)
    {
        return view('admin.committee.file-displays.show-attachments', [
            'filePathForView' => "/storage/committees/" . FileUtility::changeExtension($file),
        ]);
    }
}
