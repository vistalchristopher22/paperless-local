<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name : The name of the repository}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = $this->argument('name');

        $stub = File::get(base_path().'/stubs/repository.stub');

        $stub = str_replace('{{class}}', $name, $stub);

        File::put(app_path("Repositories/{$name}.php"), $stub);

        $this->info("{$name} Repository created successfully.");
    }
}
