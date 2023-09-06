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
        try {
            shell_exec("python.exe {$directory}\\reader.py -f {$path}");
        } catch(\Exception $e) {
            dd($e->getMessage());
        }
    }

    public static function resolveCommittees(string $path, string $directory): void
    {
        try {
            $path = escapeshellarg($path);
            $directory = escapeshellarg($directory);
            shell_exec("C:\Users\christopher\AppData\Local\Programs\Python\Python39\python.exe {$directory}\\creader.py -d {$path} 2>&1");
        } catch(\Exception $e) {
            dd($e->getMessage());
        }
    }
}
