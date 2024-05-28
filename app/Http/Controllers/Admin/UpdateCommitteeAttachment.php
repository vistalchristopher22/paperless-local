<?php

namespace App\Http\Controllers\Admin;

use App\Models\Committee;
use App\Jobs\ExtractTextJob;
use App\Jobs\ConvertDocxToPDF;
use App\Utilities\FileUtility;
use App\Http\Controllers\Controller;

final class UpdateCommitteeAttachment extends Controller
{
    public function __invoke(int $id)
    {
        $committee = Committee::find($id, ['id', 'file_path']);


        ConvertDocxToPDF::dispatch(
            $committee->file_path,
            FileUtility::publicDirectoryForViewing()
        );

        ExtractTextJob::dispatch(
            $committee->id,
            Committee::class,
            FileUtility::draftCommitteesDirectory() . basename($committee->file_path)
        );

        $committee->refresh();

        return response()->json($committee);
    }
}
