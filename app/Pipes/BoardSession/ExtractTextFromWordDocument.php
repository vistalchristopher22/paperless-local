<?php

namespace App\Pipes\BoardSession;

use Closure;
use Illuminate\Support\Str;
use App\Utilities\FileUtility;
use Illuminate\Support\Facades\Http;
use App\Contracts\Pipes\IPipeHandler;
use App\Models\BoardSessionCommitteeLink;
use Illuminate\Support\Facades\Artisan;

final class ExtractTextFromWordDocument implements IPipeHandler
{
    public function handle(mixed $payload, Closure $next)
    {
        $escaped_path = escapeshellarg($payload['boardSession']['file_path']);

        $data = shell_exec(' ' . escapeshellarg(env('LIBRE_DIRECTORY')) . ' --headless --cat ' . $escaped_path);
        $filePath = FileUtility::correctDirectorySeparator($payload['boardSession']['file_path']);
        $outputDirectory = FileUtility::publicDirectoryForViewing();
        Artisan::call('convert:path "' . FileUtility::correctDirectorySeparator($filePath) . '" --output="' . $outputDirectory . '"');

        $uuid = Str::uuid();
        BoardSessionCommitteeLink::create([
            'uuid' => $uuid,
            'view_link' => url()->to('/') . "/" . "order-business-file/link/{$uuid}" ,
            'public_path' => $outputDirectory . basename(FileUtility::changeExtension(basename($filePath))),
            'board_session_id' => $payload['boardSession']['id']
        ]);

        $utf8_cleaned_data = mb_convert_encoding($data, 'UTF-8', 'UTF-8');

        $payload['content'] = $utf8_cleaned_data;

        $response = Http::post(config('app.node_url') . '/order-business', $payload);

        if ($response->ok()) {
            dd('success!');
        } else {
            $error = $response->json('error');
        }

        return $next($payload);
    }
}
