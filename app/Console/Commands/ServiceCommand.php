<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name : The name of the service}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = $this->argument('name');

        $stub = File::get(base_path().'/stubs/service.stub');

        $stub = str_replace('{{class}}', $name, $stub);

        File::put(app_path("Services/{$name}.php"), $stub);

        $this->info("{$name} Service created successfully.");
    }
}
