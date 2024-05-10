<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use App\Utilities\FileUtility;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ConvertDocxToPDF implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $filepath, protected string $outputDirectory)
    {
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (!FileUtility::isFileExists($this->filepath) || FileUtility::isPDF($this->filepath)) {
            return;
        }

        Artisan::call('convert:path "' . FileUtility::correctDirectorySeparator($this->filepath) . '" --output="' . $this->outputDirectory . '"');
    }
}
