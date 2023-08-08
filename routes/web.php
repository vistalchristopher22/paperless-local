<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\Archive\FileBulkDeleteController;
use App\Http\Controllers\Admin\Archive\FileController;
use App\Http\Controllers\Admin\Archive\FilePreviewController;
use App\Http\Controllers\Admin\Archive\FileShowInExplorerController;
use App\Http\Controllers\Admin\BoardSessionController;
use App\Http\Controllers\Admin\BoardSessionMoveReadingController;
use App\Http\Controllers\Admin\BoardSessionPublishPreviewController;
use App\Http\Controllers\Admin\CommitteeController;
use App\Http\Controllers\Admin\CommitteeFileAttachmentController;
use App\Http\Controllers\Admin\CommitteeFileController;
use App\Http\Controllers\Admin\CommitteeMeetingScheduleController;
use App\Http\Controllers\Admin\CommitteeMeetingSchedulePreviewController;
use App\Http\Controllers\Admin\CommitteeMeetingSchedulePrintController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\FileSearchController;
use App\Http\Controllers\Admin\LegislationController;
use App\Http\Controllers\Admin\RegularSessionController;
use App\Http\Controllers\Admin\SanggunianMemberAgendaController;
use App\Http\Controllers\Admin\SanggunianMemberController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubmittedCommitteeController;
use App\Http\Controllers\Admin\UserAccessController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VenueController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\TypeController;
use App\Models\SanggunianMember;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', LandingPageController::class);
Route::get('home', [HomeController::class, 'index'])->name('home');

Route::resource('committee-file', CommitteeFileController::class);
Route::get('board-session/{dates}/published/preview', BoardSessionPublishPreviewController::class)->name('board-sessions-published.preview');
Route::get('schedule/committees/{dates}/preview', CommitteeMeetingSchedulePreviewController::class)->name('committee-meeting-schedule.preview');
Route::get('schedule/committees/{dates}/print', CommitteeMeetingSchedulePrintController::class)->name('committee-meeting-schedule.print');
Route::get('archive/list', [FileController::class, 'list'])->name('file.list');

Route::get('session_screen', [ScreenController::class, 'session_screen']);

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'features:administrator'], function () {
        Route::get('submitted-committee/list', SubmittedCommitteeController::class);
        Route::post('re-order/agenda', [AgendaController::class, 'reOrder'])->name('agenda.re-order');
        Route::get('sanggunian-member/{member}/agendas/show', SanggunianMemberAgendaController::class)->name('sanggunian-member.agendas.show');


        Route::get('legislation/list/{dates}', [LegislationController::class, 'list']);
        Route::get('legislation', [LegislationController::class, 'index'])->name('legislation.index');
        Route::get('legislation/create', [LegislationController::class, 'create'])->name('legislation.create');
        Route::post('legislation', [LegislationController::class, 'store'])->name('legislation.store');
        Route::get('legislation/edit/{id}', [LegislationController::class, 'edit'])->name('legislation.edit');
        Route::put('legislation/{id}', [LegislationController::class, 'update'])->name('legislation.update');

        Route::get('types/list', [TypeController::class, 'list']);
        Route::get('types', [TypeController::class, 'index'])->name('types.index');
        Route::post('type-store', [TypeController::class, 'store'])->name('types.store');

        Route::get('schedule/committees/{dates}', [CommitteeMeetingScheduleController::class, 'show'])->name('committee-meeting-schedule.show');
        Route::get('schedule/committees-and-session/{dates}', [CommitteeMeetingScheduleController::class, 'committeesAndSession'])->name('committee-meeting.schedule.show.committees-and-session');
        Route::get('schedule/session-only/{dates}', [CommitteeMeetingScheduleController::class, 'sessions'])->name('committee-meeting.schedule.show.session-only');
        Route::post('schedule/committees', [CommitteeMeetingScheduleController::class, 'store'])->name('committee-meeting-schedule.store');

        Route::get('board-sessions/list/{regularSession?}', [BoardSessionController::class, 'list'])->name('board-sessions.list');
        Route::post('board-session/move-reading', BoardSessionMoveReadingController::class)->name('board-session.move-reading');
        Route::post('board-sessions/locked/{board_session}', [BoardSessionController::class, 'locked'])->name('board-sessions.locked');
        Route::post('board-sessions/unlocked/{board_session}', [BoardSessionController::class, 'unlocked'])->name('board-sessions.unlocked');
        Route::post('board-sessions/published/{board_session}', [BoardSessionController::class, 'published'])->name('board-sessions.published');

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings/update', [SettingController::class, 'update'])->name('settings.update');

        Route::get('edit-information', [AccountController::class, 'edit'])->name('information.edit');
        Route::put('edit-information', [AccountController::class, 'update'])->name('information.update');

        Route::prefix('file')->group(function () {
            Route::post('archive/show-in-explorer', FileShowInExplorerController::class)->name('file.show-in-explorer');
            Route::post('archive/preview', FilePreviewController::class)->name('file.preview');
            Route::delete('archive/delete/bulk', FileBulkDeleteController::class)->name('file.delete.bulk');
            Route::post('archive/file-search', FileSearchController::class)->name('file.search');

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
            'board-sessions' => BoardSessionController::class,
            'venue' => VenueController::class,
            'files' => FileController::class,
            'regular-session' => RegularSessionController::class
        ]);
    });
});


// Route for SP-Member
Route::get('/scheduled/committee-meeting', function () {
    $dates = date('Y-m-d H:i:s');
    $dates = explode("&", $dates);

    $allSchedules = Schedule::with(['committees:id,schedule_id,lead_committee,expanded_committee,display_index', 'committees.lead_committee_information', 'committees.expanded_committee_information'])
        ->orderBy('with_invited_guest', 'DESC')
        ->orderBy('date_and_time', 'ASC')
        ->whereDay('date_and_time', date('d'))
        ->whereYear('date_and_time', date('Y'))
        ->where('type', 'committee')
        ->get();

    $schedules = $allSchedules->groupBy(function ($record) {
        return $record->date_and_time->format('Y-m-d');
    });

    $leadCommitteeIds = $allSchedules->map(function ($schedule) {
        return $schedule->committees->pluck('lead_committee')->toArray();
    })->flatten()->toArray();

    $expandedCommitteeIds = $allSchedules->map(function ($schedule) {
        return $schedule->committees->pluck('expanded_committee')->toArray();
    })->flatten()->toArray();


    $sanggunianMembers = SanggunianMember::with([
        'agenda_chairman' => function ($query) use ($leadCommitteeIds) {
            $query->whereIn('id', $leadCommitteeIds);
        },
        'agenda_vice_chairman' => function ($query) use ($leadCommitteeIds) {
            $query->whereIn('id', $leadCommitteeIds);
        },
        'agenda_member' => function ($query) use ($leadCommitteeIds) {
            $query->whereIn('agenda_id', $leadCommitteeIds);
        },
        'agenda_member.agenda',
        'expanded_agenda_chairman' => function ($query) use ($expandedCommitteeIds) {
            $query->whereIn('id', $expandedCommitteeIds);
        },
        'expanded_agenda_vice_chairman' => function ($query) use ($expandedCommitteeIds) {
            $query->whereIn('id', $expandedCommitteeIds);
        },
        'expanded_agenda_member' => function ($query) use ($expandedCommitteeIds) {
            $query->whereIn('agenda_id', $expandedCommitteeIds);
        },
        'expanded_agenda_member.agenda',
    ])->get();

    $sanggunianMembers = $sanggunianMembers->filter(function ($record) {
        return
            !$record->agenda_chairman->isEmpty() or
            !$record->agenda_vice_chairman->isEmpty() or
            !$record->agenda_member->isEmpty() or
            !$record->expanded_agenda_chairman->isEmpty() or
            !$record->expanded_agenda_vice_chairman->isEmpty() or !$record->expanded_agenda_member->isEmpty();
    });

    if ($allSchedules->count() === 0) {
        return view('no-schedule');
    } else {
        return view('sp-committee-sched-meeting', [
            'members' => $sanggunianMembers,
            'schedules' => $schedules,
            'dates' => implode('&', $dates)
        ]);
    }

})->name('scheduled.committee-meeting.today');
