<?php

namespace App\Pipes\BoardSession;

use Closure;
use Illuminate\Support\Str;
use App\Utilities\FileUtility;
use App\Contracts\Pipes\IPipeHandler;
use App\Models\BoardSessionCommitteeLink;

final class GeneratePublicLink implements IPipeHandler
{
    public function __construct()
    {
    }


    public function handle(mixed $payload, Closure $next)
    {
        $filePath = FileUtility::correctDirectorySeparator($payload['session']['file_path']);

        $outputDirectory = FileUtility::publicDirectoryForViewing();

        $uuid = Str::uuid();

        BoardSessionCommitteeLink::create([
            'uuid'        => $uuid,
            'view_link'   => "/order-business-file/link/{$uuid}",
            'public_path' => $outputDirectory . basename(FileUtility::changeExtension(basename($filePath))),
            'board_session_id' => $payload['session']['id']
        ]);

        return $next($payload);
    }
}
