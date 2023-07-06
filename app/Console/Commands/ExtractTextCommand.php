<?php

namespace App\Console\Commands;

use App\Models\Committee;
use App\Utilities\CommitteeFileUtility;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class ExtractTextCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'extract:file {id : unique ID of the record}';

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
        $record = Committee::find($this->argument('id'));
        $escaped_path = escapeshellarg(CommitteeFileUtility::draftCommitteesDirectory() .  basename($record->file_path));
        $data = shell_exec(' ' . escapeshellarg(env('LIBRE_DIRECTORY')) . ' --headless --cat ' . $escaped_path);
        $data = preg_replace('/[\n\t]/', '', $data);
        $content = Str::of($data)->remove("\n")
                             ->remove("\t")
                             ->ascii($data);
        $record->content = $content;
        $record->save();
        $this->info('Successfully extract and saved all the text inside the file.');
    }
}
