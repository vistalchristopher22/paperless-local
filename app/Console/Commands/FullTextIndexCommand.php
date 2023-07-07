<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FullTextIndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fulltext:index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create FullText Catalog and Index on SQL Server.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $database = config('database.connections.sqlsrv.database');

        DB::unprepared("USE {$database}; CREATE FULLTEXT CATALOG FullTextCatalog");
        DB::unprepared("USE {$database}; CREATE UNIQUE INDEX ui_committees ON dbo.committees(id)");
        DB::unprepared('CREATE FULLTEXT INDEX ON dbo.committees (content LANGUAGE 1033) KEY INDEX ui_committees ON FullTextCatalog WITH CHANGE_TRACKING AUTO');
        $this->info('FullText Catalog and Index created successfully!');
    }
}
