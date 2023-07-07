<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\Archive\FileBulkDeleteController;
use App\Http\Controllers\Admin\Archive\FileController;
use App\Http\Controllers\Admin\Archive\FilePreviewController;
use App\Http\Controllers\Admin\Archive\FileShowInExplorerController;
use App\Http\Controllers\Admin\BoardSessionController;
use App\Http\Controllers\Admin\CommitteeController;
use App\Http\Controllers\Admin\CommitteeFileAttachmentController;
use App\Http\Controllers\Admin\CommitteeFileController;
use App\Http\Controllers\Admin\CommitteeMeetingScheduleController;
use App\Http\Controllers\Admin\CommitteeMeetingSchedulePreviewController;
use App\Http\Controllers\Admin\CommitteeMeetingSchedulePrintController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\SanggunianMemberAgendaController;
use App\Http\Controllers\Admin\SanggunianMemberController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubmittedCommitteeController;
use App\Http\Controllers\Admin\UserAccessController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Models\Schedule;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
Auth::routes();

Route::get('home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'features:administrator'], function () {

        Route::get('submitted-committee/list', SubmittedCommitteeController::class);
        Route::post('re-order/agenda', [AgendaController::class, 'reOrder'])->name('agenda.re-order');
        Route::get('sanggunian-member/{member}/agendas/show', SanggunianMemberAgendaController::class)->name('sanggunian-member.agendas.show');

        Route::get('schedule/committees/{dates}/preview', CommitteeMeetingSchedulePreviewController::class)->name('committee-meeting-schedule.preview');
        Route::get('schedule/committees/{dates}/print', CommitteeMeetingSchedulePrintController::class)->name('committee-meeting-schedule.print');
        Route::get('schedule/committees/{dates}', [CommitteeMeetingScheduleController::class, 'show'])->name('committee-meeting-schedule.show');
        Route::post('schedule/committees', [CommitteeMeetingScheduleController::class, 'store'])->name('committee-meeting-schedule.store');

        Route::get('board-sessions/list', [BoardSessionController::class, 'list'])->name('board-sessions.list');
        Route::post('board-sessions/locked/{board_session}', [BoardSessionController::class, 'locked'])->name('board-sessions.locked');
        Route::post('board-sessions/unlocked/{board_session}', [BoardSessionController::class, 'unlocked'])->name('board-sessions.unlocked');

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings/update', [SettingController::class, 'update'])->name('settings.update');

        Route::get('edit-information', [AccountController::class, 'edit'])->name('information.edit');
        Route::put('edit-information', [AccountController::class, 'update'])->name('information.update');

        Route::prefix('file')->group(function () {
            Route::post('archive/show-in-explorer', FileShowInExplorerController::class)->name('file.show-in-explorer');
            Route::post('archive/preview', FilePreviewController::class)->name('file.preview');
            Route::delete('archive/delete/bulk', FileBulkDeleteController::class)->name('file.delete.bulk');

            Route::get('archive/list', [FileController::class, 'list'])->name('file.list');
            Route::post('files/filter/type', [FileController::class, 'filter'])->name('file.filter');
            Route::post('archive/details', [FileController::class, 'show'])->name('file.show');
            Route::post('archive/rename', [FileController::class, 'update'])->name('file.update');
            Route::post('archive/upload', [FileController::class, 'store'])->name('file.store');
            Route::delete('archive/delete', [FileController::class, 'destroy'])->name('file.delete');
        });

        Route::get('show-attachment/{url}/{location}', [CommitteeFileAttachmentController::class, 'show'])->name('show-attachment');

        Route::resources([
            'account' => UserController::class,
            'account-access-control' => UserAccessController::class,
            'sanggunian-members' => SanggunianMemberController::class,
            'agendas' => AgendaController::class,
            'division' => DivisionController::class,
            'committee' => CommitteeController::class,
            'schedules' => ScheduleController::class,
            'committee-file' => CommitteeFileController::class,
            'board-sessions' => BoardSessionController::class,
            'files' => FileController::class,
        ]);
    });
});

// Route for SP-Member
Route::get('sp-committee-sched-meeting/{dates}', function (string $dates) {
    $dates = date('Y-m-d H:i:s');
    $dates = explode("&", $dates);
    $schedules = Schedule::with(['committees', 'committees.lead_committee_infromation', 'committees.expanded_committee_information'])
        ->orderBy('with_invited_guest', 'DESC')
        ->orderBy('date_and_time', 'ASC')
        ->get()
        ->groupBy(function ($record) {
            return $record->date_and_time->format('Y-m-d');
        });


    return view('sp-committee-sched-meeting', [
        'schedules' => $schedules,
        'dates' => implode('&', $dates)
    ]);
})->name('sp-committee.shed');


Route::post('store-venue', function (Request $request) {

    Venue::create([
        'name' => $request->name
    ]);

    return response()->json(['success' => true]);
});
