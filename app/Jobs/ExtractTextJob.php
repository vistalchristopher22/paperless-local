<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ExtractTextJob implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private int $fileId, private string $model, private string $filePath)
    {
    }



    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Artisan::call('extract:file', [
            'id' => $this->fileId,
            'model' => $this->model,
            'path' => $this->filePath
        ]);
    }
}
