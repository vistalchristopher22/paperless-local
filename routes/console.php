<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

Artisan::command('clear', function () {
    DB::table('committees')->delete();
    $this->info('deleted successfully');
})->purpose('Delete all test committees data');
