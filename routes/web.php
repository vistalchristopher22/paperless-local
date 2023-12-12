<?php

// TODO the file manager rename must be update the committee file also or the committee file links

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\HomeController as AdministratorHomeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VenueController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\ScreenController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\CommitteeController;
use App\Http\Controllers\Admin\ScreenPrivilegeHour;
use App\Http\Controllers\Admin\FileSearchController;
use App\Http\Controllers\Admin\UserAccessController;
use App\Http\Controllers\Admin\FileInspectController;
use App\Http\Controllers\Admin\LegislationController;
use App\Http\Controllers\Admin\ScreenTableController;
use App\Http\Controllers\Admin\Archive\FileController;
use App\Http\Controllers\Admin\BackTrackingController;
use App\Http\Controllers\Admin\BoardSessionController;
use App\Http\Controllers\Admin\AgendaReOrderController;
use App\Http\Controllers\Admin\CommitteeFileController;
use App\Http\Controllers\Admin\InvitedGuestsController;
use App\Http\Controllers\Admin\ScreenDisplayController;
use App\Http\Controllers\Admin\ScreenOperateController;
use App\Http\Controllers\Admin\RegularSessionController;
use App\Http\Controllers\Admin\SanggunianMemberController;
use App\Http\Controllers\Admin\SubmittedCommitteeController;
use App\Http\Controllers\Admin\Archive\FilePreviewController;
use App\Http\Controllers\Admin\CommitteeFileViewerController;
use App\Http\Controllers\Admin\LegislationDownloadController;
use App\Http\Controllers\ScheduledCommitteeMeetingController;
use App\Http\Controllers\Admin\BacktrackingViewFileController;
use App\Http\Controllers\Admin\BoardSessionFileViewController;
use App\Http\Controllers\Admin\ScreenQuestionofHourController;
use App\Http\Controllers\Admin\CommitteeInvitedGuestController;
use App\Http\Controllers\Admin\Archive\FileBulkDeleteController;
use App\Http\Controllers\Admin\SanggunianMemberAgendaController;
use App\Http\Controllers\Admin\ScheduledOrderBusinessController;
use App\Http\Controllers\Admin\CommitteeMeetingScheduleController;
use App\Http\Controllers\Admin\Archive\FileShowInExplorerController;
use App\Http\Controllers\Admin\BoardSessionPublishPreviewController;
use App\Http\Controllers\Admin\CommitteeMeetingSchedulePrintController;
use App\Http\Controllers\Admin\CommitteeMeetingSchedulePreviewController;

Auth::routes();
Route::view('stay', 401);

Route::get('/', LandingPageController::class);
Route::get('home', HomeController::class)->name('home');

Route::get('archive/list', [FileController::class, 'list'])->name('file.list');
Route::get('types/list', [TypeController::class, 'list']);

Route::group(['prefix' => 'schedule', 'as' => 'committee-meeting-schedule.'], function () {
    Route::get('schedule/committees/{dates}/preview', CommitteeMeetingSchedulePreviewController::class)->name('preview');
    Route::get('schedule/committees/{dates}/print', CommitteeMeetingSchedulePrintController::class)->name('print');
});

Route::group(['prefix' => 'committee-file', 'as' => 'committee-file.'], function () {
    Route::get('{committee}/download', [CommitteeFileController::class, 'download'])->name('download');
    Route::get('link/{uuid}', CommitteeFileViewerController::class)->name('viewer');
});

Route::get('order-business-file/link/{uuid}', BoardSessionFileViewController::class)->name('board-session-file.viewer');
Route::get('board-session/{dates}/published/preview', BoardSessionPublishPreviewController::class)->name('board-sessions-published.preview');

Route::get('submitted-committee/list', SubmittedCommitteeController::class);

Route::group(['as' => 'display.screen.'], function () {
    Route::get('screen/{id}', ScreenController::class)->name('monitor');
    Route::get('screen-question-of-hour/{id}', ScreenQuestionofHourController::class)->name('question-of-hour');
    Route::get('screen-privilege-hour/{id}', ScreenPrivilegeHour::class)->name('privilege.hour');
    Route::get('screen-table/{id}', ScreenTableController::class)->name('table');
});


Route::group(['prefix' => 'scheduled'], function () {
    Route::get('order-of-business', ScheduledOrderBusinessController::class)->name('board-sessions-published.today');
    Route::get('committee-meeting', ScheduledCommitteeMeetingController::class)->name('scheduled.committee-meeting.today');
});

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'edit-information', 'as' => 'information.'], function () {
        Route::get('/', [AccountController::class, 'edit'])->name('edit');
        Route::put('/', [AccountController::class, 'update'])->name('update');
    });

    Route::group(['middleware' => 'features:administrator'], function () {

        Route::group(['prefix' => 'schedule'], function () {
            Route::get('committees/{dates}', [CommitteeMeetingScheduleController::class, 'show'])->name('committee-meeting-schedule.show');
            Route::get('committees-and-session/{dates}', [CommitteeMeetingScheduleController::class, 'committeesAndSession'])->name('committee-meeting.schedule.show.committees-and-session');
            Route::get('session-only/{dates}', [CommitteeMeetingScheduleController::class, 'sessions'])->name('committee-meeting.schedule.show.session-only');
            Route::post('committees', [CommitteeMeetingScheduleController::class, 'store'])->name('committee-meeting-schedule.store');
        });

        Route::group(['prefix' => 'board-sessions', 'as' => 'board-sessions.'], function () {
            Route::post('locked/{board_session}', [BoardSessionController::class, 'locked'])->name('locked');
            Route::post('unlocked/{board_session}', [BoardSessionController::class, 'unlocked'])->name('unlocked');
            Route::post('published/{board_session}', [BoardSessionController::class, 'published'])->name('published');
        });

        Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
            Route::get('/', [SettingController::class, 'index'])->name('index');
            Route::put('update', [SettingController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'file', 'as' => 'file.'], function () {
            Route::post('files/filter/type', [FileController::class, 'filter'])->name('filter');
            Route::post('archive/details', [FileController::class, 'show'])->name('show');
            Route::post('archive/rename', [FileController::class, 'update'])->name('update');
            Route::post('archive/upload', [FileController::class, 'store'])->name('store');
            Route::delete('archive/delete', [FileController::class, 'destroy'])->name('delete');

            Route::post('archive/show-in-explorer', FileShowInExplorerController::class)->name('show-in-explorer');
            Route::post('archive/preview', FilePreviewController::class)->name('preview');
            Route::delete('archive/delete/bulk', FileBulkDeleteController::class)->name('delete.bulk');
            Route::post('archive/file-search', FileSearchController::class)->name('search');
            Route::post('archive/inspect-link', FileInspectController::class)->name('inspect-link');
        });

        Route::group(['prefix' => 'committee-invited-guest', 'as' => 'committee.invited-guest.'], function () {
            Route::get('{id}', [CommitteeInvitedGuestController::class, 'create'])->name('create');
            Route::post('{id}', [CommitteeInvitedGuestController::class, 'store'])->name('store');
        });

        Route::resources([
            'account'                => UserController::class,
            'account-access-control' => UserAccessController::class,
            'sanggunian-members'     => SanggunianMemberController::class,
            'agendas'                => AgendaController::class,
            'division'               => DivisionController::class,
            'committee'              => CommitteeController::class,
            'schedules'              => ScheduleController::class,
            'board-sessions'         => BoardSessionController::class,
            'venue'                  => VenueController::class,
            'files'                  => FileController::class,
            'regular-session'        => RegularSessionController::class,
            'types'                  => TypeController::class,
            'backtracking'           => BackTrackingController::class,
            'committee-file'         => CommitteeFileController::class
        ]);

        Route::get('invited-guests', InvitedGuestsController::class)->name('invited-guests.index');
        Route::get('screen-display/{id}', ScreenDisplayController::class)->name('screen-display.index');
        Route::post('screen-display/operate', ScreenOperateController::class)->name('screen-display.operate');

        Route::post('re-order/agenda', AgendaReOrderController::class)->name('agenda.re-order');
        Route::get('sanggunian-member/{member}/agendas/show', SanggunianMemberAgendaController::class)->name('sanggunian-member.agendas.show');
        Route::post('backtracking/show-explorer', BacktrackingViewFileController::class)->name('backtracking.show-explorer');
    });
});

Route::group(['prefix' => 'administrator', 'middleware' => 'auth'], function () {
    Route::get('home', [AdministratorHomeController::class, 'index'])->name('administrator.home');


    Route::get('legislation/download/{id}', LegislationDownloadController::class)->name('legislation.attachment.download');
    Route::post('update-legislation/{legislation}', [LegislationController::class, 'updateLegislation']);

    Route::resources([
        'legislation' => LegislationController::class,
    ]);
});
