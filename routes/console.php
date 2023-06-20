<?php

use App\Models\Committee;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Artisan;

Artisan::command('rebase', function () {
    UserNotification::truncate();
    Committee::get()->each(function ($row) {
        $row->status = 'review';
        $row->save();
    });
    $this->info('success!');
})->purpose('Display an inspiring quote');
