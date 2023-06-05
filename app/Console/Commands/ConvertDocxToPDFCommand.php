<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ConvertDocxToPDFCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:path {path : file path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert docx document to pdf';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $outputDirectory = base_path() . '/storage/app/public/board-sessions/';

        $baseName = basename($this->argument('path'));

        $inputDirectory = base_path() . '/storage/app/public/board-sessions/' . $baseName;

        $inputDirectory = str_replace('/', '\\', $inputDirectory);

        $result = shell_exec('"C:\Program Files\LibreOffice\program\soffice" --headless --convert-to pdf "' .$inputDirectory .'" --outdir ' . $outputDirectory);
        if(Str::contains($result, "convert")) {
            $this->info("File converted successfully");
        } else {
            Log::info($result);
        }
    }
}
