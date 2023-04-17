<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\Archieve\FileController;
use App\Http\Controllers\Admin\BoardSessionController;
use App\Http\Controllers\Admin\CommitteeController;
use App\Http\Controllers\Admin\CommitteeFileController;
use App\Http\Controllers\Admin\SanggunianMemberAgendaController;
use App\Http\Controllers\Admin\SanggunianMemberController;
use App\Http\Controllers\Admin\UserAccessController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\CommitteeController as UserCommitteeController;
use App\Models\BoardSession;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Auth::routes();

Route::get('home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'features:administrator'], function () {
        Route::group(['model' => User::class], fn () => Route::resource('account', UserController::class));
        Route::resource('account-access-control', UserAccessController::class);

        Route::get('sanggunian-member/{member}/agendas/show', SanggunianMemberAgendaController::class)->name('sanggunian-member.agendas.show');
        Route::resource('sanggunian-members', SanggunianMemberController::class);
        Route::post('re-order/agenda', [AgendaController::class, 'reOrder'])->name('agenda.re-order');
        Route::resource('agendas', AgendaController::class);

        Route::resource('division', DivisionController::class);

        Route::resource('committee-file', CommitteeFileController::class);
        Route::get('committee-list/{lead?}/{expanded?}/{content?}', [CommitteeController::class, 'list'])->name('committee.list');
        Route::resource('committee', CommitteeController::class);

        Route::get('board-sessions/list', [BoardSessionController::class, 'list'])->name('board-sessions.list');
        Route::post('board-sessions/locked/{board_session}', [BoardSessionController::class, 'locked'])->name('board-sessions.locked');
        Route::post('board-sessions/unlocked/{board_session}', [BoardSessionController::class, 'unlocked'])->name('board-sessions.unlocked');

        Route::group(['base_rule' => 'order_business', 'model' => BoardSession::class], fn () => Route::resource('board-sessions', BoardSessionController::class));


        Route::post('files/get', [FileController::class, 'getFiles']);
        Route::resource('files', FileController::class);
    });

    Route::get('edit-information', [AccountController::class, 'edit'])->name('information.edit');
    Route::put('edit-information', [AccountController::class, 'update'])->name('information.update');
});


Route::group(['prefix' => 'user', 'middleware' => ['auth', 'features:user']], function () {
    Route::get('user-committees', [UserCommitteeController::class, 'index'])->name('user.committee.index');
});
