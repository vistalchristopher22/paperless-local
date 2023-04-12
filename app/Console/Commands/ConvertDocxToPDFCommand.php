<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        $directory = dirname($this->argument('path'));
        $directory = str_replace("public\\", "", $directory);
        $directory = str_replace("storage\\", "storage\\app\\public\\", $directory);
        shell_exec('"C:\\Program Files\\LibreOffice\\program\\soffice" --headless --convert-to pdf ' . $this->argument('path') .  ' --outdir ' .  $directory);
        $this->info('Converted Successfully');
    }
}
