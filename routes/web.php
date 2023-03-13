<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\SanggunianMemberController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DivisionController;

Route::redirect('/', '/login');

Route::get('login-administrator', function () {
    echo 'hello login administrator';
})->name('admin.auth.login');

Route::get('sample', function () {
    echo 'hello administrator';
})->name('admin.dashboard');

Auth::routes();

Route::get('home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'features:administrator'], function () {
        Route::resource('account', UserController::class);
        Route::resource('sanggunian-members', SanggunianMemberController::class);
        Route::resource('agendas', AgendaController::class);
        Route::resource('division', DivisionController::class);
    });

    Route::get('edit-information', [AccountController::class, 'edit'])->name('information.edit');
    Route::put('edit-information', [AccountController::class, 'update'])->name('information.update');
});
