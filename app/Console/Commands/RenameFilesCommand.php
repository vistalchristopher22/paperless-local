<?php

namespace App\Console\Commands;

use App\Services\ArchiveFileService;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RenameFilesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rename-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rename files in the source directory with a Unix timestamp prefix.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $fileTypes = Arr::flatten(ArchiveFileService::FILE_TYPES);

        $fileTypes = array_diff($fileTypes, ['*']);

        $fileTypes = array_map(function ($value) {
            return str_replace('*', '', $value);
        }, $fileTypes);

        $files = Storage::disk('source')->files();

        foreach ($files as $file) {
            if (!(Str::contains($file, $fileTypes))) {
                continue;
            }
            if (preg_match('/^\d+_/', $file)) {
                continue;
            }

            $newFileName = $this->addTimestampPrefix($file);
            Storage::disk('source')->move($file, $newFileName);
            $this->info("File $file renamed to $newFileName");
        }

        $this->info('File renaming completed.');
    }

    private function addTimestampPrefix(string $filename): string
    {
        $timestamp = time();
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $name = pathinfo($filename, PATHINFO_FILENAME);
        return "{$timestamp}_{$name}.{$ext}";
    }
}
