<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PipeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:pipe {name : The name of the pipe}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new pipe class';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');

        $stub = File::get(base_path() . '/stubs/pipe.stub');

        $stub = str_replace('{{name}}', basename($name), $stub);

        $directory = app_path("Pipes/{$name}.php");
        $namespace = Str::between($directory, app_path('Pipes/'), basename($directory));

        $stub = str_replace('{{namespace}}', rtrim($namespace, '\\'), $stub);

        if (!is_dir(dirname($directory))) {
            File::makeDirectory(dirname($directory), $mode = 0777, $recursive = true);
        }
        if (File::exists($directory)) {
            $this->warn("Pipe {$directory} already exists.");
        } else {
            File::put($directory, $stub);
            $this->info('Pipe created successfully!');
        }
    }
}
