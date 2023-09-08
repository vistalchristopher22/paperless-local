<?php

namespace App\Pipes\Committee;

use Closure;
use App\Models\Committee;
use Illuminate\Support\Str;
use App\Utilities\FileUtility;
use App\Models\CommitteeFileLink;
use App\Contracts\Pipes\IPipeHandler;
use Illuminate\Support\Facades\Artisan;

final class ExtractFileText implements IPipeHandler
{
    public function __construct()
    {
    }

    public function handle(mixed $payload, Closure $next)
    {
        $payload->load('file_link')->file_link()->delete();

        $filePath = FileUtility::correctDirectorySeparator($payload['file_path']);
        $outputDirectory = FileUtility::publicDirectoryForViewing();
        Artisan::call('convert:path "' . FileUtility::correctDirectorySeparator($filePath) . '" --output="' . $outputDirectory . '"');

        $uuid = Str::uuid();

        CommitteeFileLink::create([
            'uuid' => $uuid,
            'view_link' => url()->to('/') . "/" . "committee-file/link/{$uuid}" ,
            'public_path' => $outputDirectory . basename(FileUtility::changeExtension($filePath)),
            'committee_id' => $payload['id']
        ]);

        Artisan::call('extract:file ' . $payload->id);
        $committee = Committee::find($payload->id);
        return $next($committee);
    }
}
