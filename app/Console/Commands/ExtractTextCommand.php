<?php

namespace App\Console\Commands;

use App\Models\Committee;
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
    public function handle(): void
    {
        $record = Committee::find($this->argument('id'));
        $path = str_replace('storage', 'public\\storage', $record->file_path);
        $data = shell_exec('"C:\\Program Files\\LibreOffice\\program\\soffice" --headless --cat ' . $path);
        $cleanString = preg_replace('/[\n\t]/', '', $data);
        $record->content = Str::ascii(Str::of(strip_tags(nl2br($cleanString))));
        $record->save();
        $this->info('Successfully extract and saved all the text inside the file.');
    }
}
