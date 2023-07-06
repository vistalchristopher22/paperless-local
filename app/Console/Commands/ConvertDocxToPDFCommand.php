<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ConvertDocxToPDFCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:path {path : file path} {--output= : output directory}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert docx document to pdf and save to the specified output directory';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            $outputDirectory = $this->option('output');
            $inputDirectory = $this->argument('path');

            if (! $outputDirectory) {
                throw new Exception('Output directory not specified');
            }

            if (! $inputDirectory) {
                throw new Exception('Input directory not specified');
            }

            $result = shell_exec('"C:\Program Files\LibreOffice\program\soffice" --headless --convert-to pdf "'.$inputDirectory.'" --outdir '.$outputDirectory);

            if (Str::contains($result, 'convert')) {
                $this->info('File converted successfully');
            } else {
                Log::info($result);
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
