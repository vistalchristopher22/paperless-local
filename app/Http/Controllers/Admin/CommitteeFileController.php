<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Committee;
use App\Resolvers\PDFLinkResolver;
use App\Utilities\FileUtility;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

final class CommitteeFileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'features:administrator'])->only('edit');
    }

    public function show(int $committee)
    {
        $committee = Committee::find($committee, ['id', 'file_path']);

        $pathForView = Cache::rememberForever('committee_file_' . $committee->id, function () use ($committee) {
            PDFLinkResolver::resolveCommittees(dirname(FileUtility::correctDirectorySeparator($committee->file_path)), base_path());
            return "/storage/committees/" . FileUtility::changeExtension(basename($committee->file_path));
        });

        return view('admin.committee.file-displays.show', [
            'filePathForView' => $pathForView,
        ]);


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
