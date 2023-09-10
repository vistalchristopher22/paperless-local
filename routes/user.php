<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AgendaController;
use App\Http\Controllers\User\SessionController;
use App\Http\Controllers\User\DivisionController;
use App\Http\Controllers\User\CommitteeController;
use App\Http\Controllers\User\DisplayScheduleController;
use App\Http\Controllers\User\DisplaySchedulePrintController;
use App\Http\Controllers\User\SanggunianMemberController as BoardMembersController;

Route::group(['prefix' => 'user', 'middleware' => ['auth', 'features:user']], function () {
    Route::get('committee-list/{lead?}/{expanded?}/{ids?}/{regularSession?}', [CommitteeController::class, 'list'])->name('user.committee.list');
    Route::get('board-sessions/list/{regularSession?}', [SessionController::class, 'list'])->name('user.board-sessions.list');
    Route::resource('committee', CommitteeController::class, ['as' => 'user'])->except(['destroy', 'show']);

    Route::name('user.')->group(function () {
        Route::get('agendas', AgendaController::class)->name('agendas.index');
        Route::get('divisions', DivisionController::class)->name('divisions.index');

        Route::get('order-of-business/list', [SessionController::class, 'list'])->name('sessions.list');
        Route::get('order-of-business', [SessionController::class, 'index'])->name('sessions.index');
        Route::get('order-of-business/create', [SessionController::class, 'create'])->name('sessions.create');
        Route::post('order-of-business', [SessionController::class, 'store'])->name('sessions.store');

        Route::get('order-of-business/{session}/edit', [SessionController::class, 'edit'])->name('sessions.edit');
        Route::put('order-of-business/{session}', [SessionController::class, 'update'])->name('sessions.update');
        
        Route::get('sanggunian-members', [BoardMembersController::class, 'index'])->name('sanggunian-members.index');
        Route::get('sanggunian-members/{member}/agendas/show', [BoardMembersController::class, 'show'])->name('sanggunian-member.agendas.show');
        Route::get('schedules/{dates}', DisplayScheduleController::class)->name('schedules.index');
        Route::get('schedules/{dates}/print', DisplaySchedulePrintController::class)->name('schedules.print');

    });
});
