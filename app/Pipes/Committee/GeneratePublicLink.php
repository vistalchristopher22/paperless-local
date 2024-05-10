<?php

namespace App\Pipes\Committee;

use App\Contracts\Pipes\IPipeHandler;
use App\Models\CommitteeFileLink;
use App\Utilities\FileUtility;
use Closure;

class GeneratePublicLink implements IPipeHandler
{
    public function __construct()
    {
    }

    public function handle(mixed $payload, Closure $next)
    {
        if (!isset($payload['file_path'])) {
            return $next($payload);
        }

        $uuid = str()->uuid();
        $outputDirectory = FileUtility::publicDirectoryForViewing();
        CommitteeFileLink::create([
            'uuid'        => $uuid,
            'view_link'   => "/committee-file/link/{$uuid}",
            'public_path' => $outputDirectory . basename(FileUtility::changeExtension(basename($payload['file_path']))),
            'committee_id' => $payload['id']
        ]);

        return $next($payload);
    }
}
