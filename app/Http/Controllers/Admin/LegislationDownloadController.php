<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Legislation;
use App\Utilities\FileUtility;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Response;

final class LegislationDownloadController extends Controller
{
    public function __invoke(int $id)
    {
        $data = Legislation::with(['legislable'])->find($id);
        $file = $data->legislable->file;

        if (FileUtility::isPDF($file)) {
            return Response::download(dirname($file) . DIRECTORY_SEPARATOR . basename(FileUtility::changeExtension($file)), basename($file));
        } else {
            $outputDirectory = FileUtility::publicDirectoryForViewing();
            $location = FileUtility::correctDirectorySeparator($file);
            Artisan::call('convert:path "' . FileUtility::isInputDirectoryEscaped($location) . '" --output="' . $outputDirectory . '"');
            return Response::download($outputDirectory . basename(FileUtility::changeExtension($file)), basename($file));
        }
    }
}
