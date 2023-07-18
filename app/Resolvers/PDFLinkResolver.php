<?php

namespace App\Resolvers;

use Illuminate\Support\Facades\Log;

final class PDFLinkResolver implements IResolver
{
    public function __construct(string $path, string $directory = null)
    {
        $this->resolve(escapeshellarg($path), $directory ?? base_path());
    }

    public function resolve(string $path, string $directory): void
    {
        try {
            shell_exec("python.exe {$directory}\\reader.py -f {$path}");
            Log::info('PDF Link: ' . $path);
        } catch(\Exception $e) {
            dd($e->getMessage());
        }
    }
}
