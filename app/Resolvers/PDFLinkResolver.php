<?php

namespace App\Resolvers;

final class PDFLinkResolver implements IResolver
{
    public function __construct(string $path, string $directory = null)
    {
        $this->resolve(escapeshellarg($path), $directory ?? base_path());
    }

    public function resolve(string $path, string $directory): void
    {
        shell_exec("python.exe {$directory}\\reader.py -f {$path}");
    }
}
