<?php

namespace App\Http\Controllers\Admin;

use App\Models\Committee;
use Illuminate\Support\Str;
use App\Utilities\FileUtility;
use App\Resolvers\PDFLinkResolver;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Response;

final class CommitteeFileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'features:administrator'])->only('edit');
    }

    public function show(int $committee)
    {
        $committee = Committee::with('file_link')->find($committee, ['id', 'file_path']);
        return redirect()->to($committee->file_link->view_link);
    }


    public function edit(Committee $committee_file)
    {
        return $committee_file;
    }

    public function download(Committee $committee)
    {
        return Response::download(FileUtility::correctDirectorySeparator($committee->file_path), removeTimestampPrefix(basename($committee->file_path)));
    }
}
