<?php

namespace App\Pipes\BoardSession;

use App\Contracts\Pipes\IPipeHandler;
use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

final class CreateTemplateFile implements IPipeHandler
{
    public const HIDE_FILE_SYMBOL = ".";

    public function handle(mixed $payload, Closure $next)
    {
        $path = $payload['session']['file_path'];

        $templateFile = dirname($path) . DIRECTORY_SEPARATOR . self::HIDE_FILE_SYMBOL . basename($path);

        copy($path, $templateFile);

        $payload['session']['file_template'] = $templateFile;
        $payload['session']->save();

        $response = Http::asForm()->post('http://127.0.0.1:5000/replace-section', [
            'document_path' => $path,
            'start_delimiter' => 'BEGIN_UNASSIGNED',
            'end_delimiter' => 'END_UNASSIGNED',
            'new_content' => Str::of($payload['unassigned_business_content'])->stripTags()->value(),
        ]);

        $response = Http::asForm()->post('http://127.0.0.1:5000/replace-section', [
            'document_path' => $path,
            'start_delimiter' => 'BEGIN_ANNOUNCEMENT',
            'end_delimiter' => 'END_ANNOUNCEMENT',
            'new_content' => Str::of($payload['announcement_content'])->stripTags()->value(),
        ]);

        return $next($payload);
    }


}
