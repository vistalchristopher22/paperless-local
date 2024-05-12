<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class ExtractTextCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'extract:file {id : unique ID of the record} {model : the model to be used} {path : the path of the file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'extract all the text of a file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $model = app()->make($this->argument('model'));
        $record = $model->find($this->argument('id'));
        $path = $this->argument('path');
        $escaped_path = escapeshellarg($path);
        $data = shell_exec(' ' . escapeshellarg(env('LIBRE_DIRECTORY')) . ' --headless --cat ' . $escaped_path);
        $data = preg_replace('/[\n\t]/', '', $data);

        $content = Str::of($data)->remove("\n")
            ->remove("\t")
            ->ascii($data);

        if (Schema::hasColumn($model->getTable(), 'content')) {
            $record->content = $content;
            $record->save();
        }

        $this->info('Successfully extract and saved all the text inside the file.');
    }
}
