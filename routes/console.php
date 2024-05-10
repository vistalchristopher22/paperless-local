<?php

use App\Models\Committee;
use App\Models\ScreenDisplay;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Artisan;

Artisan::command('rebase', function () {
    ScreenDisplay::get()->each->delete();
})->purpose('Display an inspiring quote');
