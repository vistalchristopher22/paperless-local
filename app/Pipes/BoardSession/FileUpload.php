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

            $session = $payload['boardSession'] ?? $payload['session'];

            $location = FileUtility::correctDirectorySeparator($this->service->handle($payload['file_path'], 'BOARD_SESSIONS'));

            $session->file_path = $location;

            $fileName = basename($location);

            $outputDirectory = FileUtility::publicDirectoryForViewing();

            Artisan::call('convert:path "' . FileUtility::isInputDirectoryEscaped($location) . '" --output="' . $outputDirectory . '"');

            $boardSessionPathForView = FileUtility::generatePathForViewing($outputDirectory, $fileName);


            $session->file_path_view = $boardSessionPathForView;

            $session->save();

            new PDFLinkResolver($outputDirectory . FileUtility::changeExtension($fileName));
        }


        if (request()->has('unassigned_business')) {

            $session = $payload['boardSession'] ?? $payload['session'];

            $location = FileUtility::correctDirectorySeparator($this->service->handle($payload['unassigned_business'], 'UNASSIGNED_BUSINESS'));

            $session->unassigned_business_file_path = $location;

            $fileName = basename($location);

            $outputDirectory = FileUtility::publicDirectoryForViewing();

            Artisan::call('convert:path "' . FileUtility::isInputDirectoryEscaped($location) . '" --output="' . $outputDirectory . '"');

            $unAssignedBusinessFilePath = FileUtility::generatePathForViewing($outputDirectory, $fileName);


            $session->unassigned_business_file_path_view = $unAssignedBusinessFilePath;

            $session->save();

            new PDFLinkResolver($outputDirectory . FileUtility::changeExtension($fileName));

        }

        return $next($payload);
    }
}
