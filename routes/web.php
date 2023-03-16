<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\CommitteeController;
use App\Http\Controllers\Admin\CommitteeFileController;
use App\Http\Controllers\Admin\SanggunianMemberController;

Route::redirect('/', '/login');

Auth::routes();

Route::get('home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'features:administrator'], function () {
        Route::resource('account', UserController::class);

        Route::resource('sanggunian-members', SanggunianMemberController::class);

        Route::post('re-order/agenda', [AgendaController::class, 'reOrder'])->name('agenda.re-order');
        Route::resource('agendas', AgendaController::class);

        Route::resource('division', DivisionController::class);


        Route::resource('committee-file', CommitteeFileController::class);
        Route::resource('committee', CommitteeController::class);
    });

    Route::get('edit-information', [AccountController::class, 'edit'])->name('information.edit');
    Route::put('edit-information', [AccountController::class, 'update'])->name('information.update');
});
