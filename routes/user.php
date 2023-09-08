<?php

use App\Http\Controllers\User\AgendaController;
use App\Http\Controllers\User\CommitteeController;
use App\Http\Controllers\User\DisplayScheduleController;
use App\Http\Controllers\User\DisplaySchedulePrintController;
use App\Http\Controllers\User\DivisionController;
use App\Http\Controllers\User\SanggunianMemberController as BoardMembersController;
use App\Http\Controllers\User\SessionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'user', 'middleware' => ['auth', 'features:user']], function () {
    Route::get('committees', [CommitteeController::class, 'list'])->name('user.committee.list');
    Route::resource('committee', CommitteeController::class, ['as' => 'user'])->except(['destroy', 'show']);

    Route::name('user.')->group(function () {
        Route::get('agendas', AgendaController::class)->name('agendas.index');
        Route::get('divisions', DivisionController::class)->name('divisions.index');

        Route::get('sessions', [SessionController::class, 'list'])->name('sessions.list');
        Route::get('session', [SessionController::class, 'index'])->name('sessions.index');

        Route::get('sanggunian-members', [BoardMembersController::class, 'index'])->name('sanggunian-members.index');
        Route::get('sanggunian-members/{member}/agendas/show', [BoardMembersController::class, 'show'])->name('sanggunian-member.agendas.show');
        Route::get('schedules/{dates}', DisplayScheduleController::class)->name('schedules.index');
        Route::get('schedules/{dates}/print', DisplaySchedulePrintController::class)->name('schedules.print');
    });
});
