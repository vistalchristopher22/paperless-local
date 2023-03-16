<?php

use App\Http\Controllers\Admin\Api\AgendaMemberController;
use Illuminate\Support\Facades\Route;

Route::get('agenda-members/{agenda}', [AgendaMemberController::class, 'members']);
