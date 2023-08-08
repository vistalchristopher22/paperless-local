<?php

namespace App\Pipes\BoardSession;

use App\Contracts\Pipes\IPipeHandler;
use App\Resolvers\PDFLinkResolver;
use App\Services\UploadFileService;
use App\Utilities\FileUtility;
use Closure;
use Illuminate\Support\Facades\Artisan;

final class FileUpload implements IPipeHandler
{
    protected UploadFileService $service;

    public function __construct()
    {
        $this->service = app()->make(UploadFileService::class);
    }

    public function handle(mixed $payload, Closure $next)
    {

        if (request()->has('file_path')) {
            try {
                $session = $payload['boardSession'] ?? $payload['session'];

                $location = FileUtility::correctDirectorySeparator($this->service->handle($payload['file_path'], 'BOARD_SESSIONS'));
                $templateFileName = FileUtility::hideFile($location);

                copy($location, $templateFileName);

                $session->file_path = $location;
                $session->file_template = $templateFileName;

                $fileName = basename($location);

                $outputDirectory = FileUtility::publicDirectoryForViewing();

                Artisan::call('convert:path "' . FileUtility::isInputDirectoryEscaped($location) . '" --output="' . $outputDirectory . '"');

                $boardSessionPathForView = FileUtility::generatePathForViewing($outputDirectory, $fileName);

                $session->file_path_view = $boardSessionPathForView;
                // $session->file_template =

                $session->save();

                new PDFLinkResolver($outputDirectory . FileUtility::changeExtension($fileName));
            } catch(\Exception $e) {
                dd($e->getMessage());
            }
        }


        return $next($payload);
    }
}
