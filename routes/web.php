<?php

// TODO the file manager rename must be update the committee file also or the committee file links

use App\Enums\ScheduleType;
use App\Models\Setting;
use App\Models\Schedule;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Utilities\FileUtility;
use App\Models\ReferenceSession;
use App\Models\SanggunianMember;
use App\Models\CommitteeFileLink;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Finder\Finder;
use Illuminate\Support\Facades\Route;
use App\Repositories\SettingRepository;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TypeController;
use App\Models\BoardSessionCommitteeLink;
use App\Http\Controllers\AccountController;
use App\Repositories\ScreenDisplayRepository;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VenueController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\ScreenController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\CommitteeController;
use App\Http\Controllers\Admin\FileSearchController;
use App\Http\Controllers\Admin\UserAccessController;
use App\Http\Controllers\Admin\LegislationController;
use App\Http\Controllers\Admin\ScreenTableController;
use App\Http\Controllers\Admin\Archive\FileController;
use App\Http\Controllers\Admin\BackTrackingController;
use App\Http\Controllers\Admin\BoardSessionController;
use App\Http\Controllers\Admin\CommitteeFileController;
use App\Http\Controllers\Admin\InvitedGuestsController;
use App\Http\Controllers\Admin\ScreenDisplayController;
use App\Http\Controllers\Admin\RegularSessionController;
use App\Http\Controllers\Admin\SanggunianMemberController;
use App\Http\Controllers\Admin\SubmittedCommitteeController;
use App\Http\Controllers\Admin\Archive\FilePreviewController;
use App\Http\Controllers\Admin\LegislationDownloadController;
use App\Http\Controllers\Admin\CommitteeInvitedGuestController;
use App\Http\Controllers\Admin\Archive\FileBulkDeleteController;
use App\Http\Controllers\Admin\SanggunianMemberAgendaController;
use App\Http\Controllers\Admin\BoardSessionMoveReadingController;
use App\Http\Controllers\Admin\CommitteeFileAttachmentController;
use App\Http\Controllers\Admin\CommitteeMeetingScheduleController;
use App\Http\Controllers\Admin\Archive\FileShowInExplorerController;
use App\Http\Controllers\Admin\BoardSessionPublishPreviewController;
use App\Http\Controllers\Admin\CommitteeMeetingSchedulePrintController;
use App\Http\Controllers\Admin\CommitteeMeetingSchedulePreviewController;
use App\Models\BoardSession;

Auth::routes();

Route::get('/', LandingPageController::class);
Route::get('home', [HomeController::class, 'index'])->name('home');

Route::get("committee-file/{committee}/download", [CommitteeFileController::class, 'download'])->name('committee-file.download');
Route::resource('committee-file', CommitteeFileController::class);
Route::get('board-session/{dates}/published/preview', BoardSessionPublishPreviewController::class)->name('board-sessions-published.preview');
Route::get('schedule/committees/{dates}/preview', CommitteeMeetingSchedulePreviewController::class)->name('committee-meeting-schedule.preview');
Route::get('schedule/committees/{dates}/print', CommitteeMeetingSchedulePrintController::class)->name('committee-meeting-schedule.print');
Route::get('archive/list', [FileController::class, 'list'])->name('file.list');
Route::get('legislation/download/{id}', LegislationDownloadController::class)->name('legislation.attachment.download');
Route::get('legislation/list/{dates}/{author}/{type}/{classification}/{sponsors}', [LegislationController::class, 'list'])->name('legislation.list');

Route::get('show-attachment/{url}/{location}', [CommitteeFileAttachmentController::class, 'show'])->name('show-attachment');
Route::get('submitted-committee/list', SubmittedCommitteeController::class);

Route::get('screen/{id}', ScreenController::class)->name('display.screen.monitor');
Route::get('screen-session/{id}', function (int $id) {
    $screenDisplayRepository = app()->make(ScreenDisplayRepository::class);
    $settingRepository = app()->make(SettingRepository::class);

    $data = ReferenceSession::with(['scheduleSessions', 'scheduleCommittees.committees', 'scheduleCommittees.committees.committee_invited_guests', 'scheduleCommittees.committees.lead_committee_information', 'scheduleSessions.board_sessions'])->find($id);


    $session = $data->scheduleSessions->first();

    return view('admin.screen.screen-session', [
        'data' => $data,
        'dataToPresent' => $session,
        'upNextData' => [],
        'sanggunianMembers' => SanggunianMember::get(),
        'announcementRunningSpeed' => $settingRepository->getValueByName('announcement_running_speed'),
        'announcement' => $settingRepository->getValueByName('display_announcement'),
        'fontSize' => $settingRepository->getValueByName('screen_font_size') ?? 1.9,
        'chairmanNameFontSize' => $settingRepository->getValueByName('screen_font_size') ?? 1.9,
        'membersNameFontSize' => $settingRepository->getValueByName('screen_font_size') ?? 1.9,
    ]);
});
Route::get('screen-table/{id}', ScreenTableController::class)->name('display.screen.table');

Route::group(['middleware' => 'auth'], function () {
    Route::get('edit-information', [AccountController::class, 'edit'])->name('information.edit');
    Route::put('edit-information', [AccountController::class, 'update'])->name('information.update');

    Route::group(['middleware' => 'features:administrator'], function () {
        Route::post('re-order/agenda', [AgendaController::class, 'reOrder'])->name('agenda.re-order');
        Route::get('sanggunian-member/{member}/agendas/show', SanggunianMemberAgendaController::class)->name('sanggunian-member.agendas.show');

        Route::get('types/list', [TypeController::class, 'list']);

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
            Route::post('archive/inspect-link', function (Request $request) {
                $fileLinkRecord = CommitteeFileLink::where('public_path', 'like', '%' . FileUtility::changeExtension($request->fileName) . '%')->first();
                return response()->json(['view_link' => $fileLinkRecord->view_link]);
            })->name('file.inspect-link');
        });

        Route::get('committee-invited-guest/{id}', [CommitteeInvitedGuestController::class, 'create'])->name('committee.invited-guest');
        Route::post('committee-invited-guest/{id}', [CommitteeInvitedGuestController::class, 'store'])->name('committee.invited-guest.store');


        Route::get('invited-guests', InvitedGuestsController::class)->name('invited-guests.index');

        Route::get('screen-display/{id}', [ScreenDisplayController::class, 'show'])->name('admin.screen-display.index');
        Route::post('screen-display/re-order', [ScreenDisplayController::class, 'reOrder'])->name('admin.screen-display.re-order');
        Route::post('announcement', function (Request $request) {
            if (array_key_exists('announcement', $request->all())) {
                Setting::updateOrCreate(['name' => 'display_announcement'], ['value' => $request->announcement]);
            }

            if (array_key_exists('screen_font_size', $request->all())) {
                Setting::updateOrCreate(['name' => 'screen_font_size'], ['value' => $request->screen_font_size]);
            }

            if (array_key_exists('announcement_running_speed', $request->all())) {
                Setting::updateOrCreate(['name' => 'announcement_running_speed'], ['value' => $request->announcement_running_speed]);
            }


            return back()->with('success', 'Announcement Updated');
        })->name('announcements.store');
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
            'regular-session' => RegularSessionController::class,
            'legislation' => LegislationController::class,
            'types' => TypeController::class,
            'backtracking' => BackTrackingController::class,
        ]);

        Route::post('backtracking/show-explorer', function (Request $request) {
            $basePath = base_path();
            $escaped_path = escapeshellarg($request->path);
            dd("python.exe $basePath\\explorer.py $escaped_path");
            shell_exec("python.exe $basePath\\explorer.py $escaped_path");
        })->name('backtracking.show-explorer');
    });
});


Route::get('/scheduled/committee-meeting', function () {
    $dates = date('Y-m-d H:i:s');
    $dates = explode("&", $dates);

    $allSchedules = Schedule::with(['committees:id,schedule_id,lead_committee,expanded_committee,display_index,invited_guests', 'committees.lead_committee_information', 'committees.expanded_committee_information', 'committees.committee_invited_guests'])
        ->orderBy('with_invited_guest', 'DESC')
        ->orderBy('date_and_time', 'ASC')
        ->whereDay('date_and_time', date('d'))
        ->whereYear('date_and_time', date('Y'))
        ->where('type', 'committee')
        ->get();


    $referenceSessionCount = ReferenceSession::count();
    $scheduleCount = Schedule::count();

    if ($referenceSessionCount == 0 && $scheduleCount == 0) {
        return redirect()->route('login');
    }


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
        $latestCommittees = ReferenceSession::with('scheduleCommittees')->whereHas('scheduleCommittees')->whereHas('scheduleCommittees.committees')->orderBy('number', 'DESC')->first();
        $schedules = $latestCommittees->scheduleCommittees->groupBy(function ($record) {
            return $record->date_and_time->format('Y-m-d');
        });

        $schedules = $latestCommittees->scheduleCommittees->groupBy(function ($record) {
            return $record->date_and_time->format('Y-m-d');
        });
    
        $leadCommitteeIds = $latestCommittees->scheduleCommittees->map(function ($schedule) {
            return $schedule->committees->pluck('lead_committee')->toArray();
        })->flatten()->toArray();
    
        $expandedCommitteeIds = $latestCommittees->scheduleCommittees->map(function ($schedule) {
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

        return view('sp-committee-sched-meeting', [
            'members' => $sanggunianMembers,
            'schedules' => $schedules,
            'dates' => implode('&', $dates)
        ]);
    } else {
        return view('sp-committee-sched-meeting', [
            'members' => $sanggunianMembers,
            'schedules' => $schedules,
            'dates' => implode('&', $dates)
        ]);
    }
})->name('scheduled.committee-meeting.today');

Route::get('/scheduled/order-of-business', function () {
    $latestReferenceSession = ReferenceSession::with('scheduleSessions')->whereHas('scheduleSessions')->whereHas('scheduleSessions.board_sessions')->orderBy('number', 'DESC')->first();
    $session = $latestReferenceSession?->scheduleSessions?->first()?->board_sessions->first();

    $outputDirectory = FileUtility::publicDirectoryForViewing();
    $location = FileUtility::correctDirectorySeparator($session->file_path);
    Artisan::call('convert:path "' . FileUtility::isInputDirectoryEscaped($location) . '" --output="' . $outputDirectory . '"');

    return view('admin.board-sessions.display', [
        'orderBusinessView' => $session->file_path_view,
        'announcementTitle' => $session->announcement_title,
        'announcementContent' => $session->announcement_content,
    ]);
})->name('board-sessions-published.today');

Route::get('stay', function () {
    dd('Please contact PADMO-ITU to fix this system.');
})->name('stay');


Route::get('/committee-file/link/{uuid}', function (string $uuid) {
    $committeeFileLink = CommitteeFileLink::with('committee')->where('uuid', $uuid)->first();
    $outputDirectory = FileUtility::publicDirectoryForViewing();

    if (!is_null($committeeFileLink->committee)) {

        if (file_exists($committeeFileLink->committee->file_path)) {
            Artisan::call('convert:path "' . FileUtility::correctDirectorySeparator($committeeFileLink->committee->file_path) . '" --output="' . $outputDirectory . '"');
            $pathForView = "/storage/committees/" . FileUtility::changeExtension(basename($committeeFileLink->committee->file_path));
        }
    } else {
        // check if file is exists
        if (file_exists($committeeFileLink->public_path)) {
            Artisan::call('convert:path "' . FileUtility::correctDirectorySeparator($committeeFileLink->public_path) . '" --output="' . $outputDirectory . '"');
            $pathForView = "/storage/committees/" . FileUtility::changeExtension(basename($committeeFileLink->public_path));
        } else {
            $finder = new Finder();
            $finderFile = iterator_to_array($finder->files()->in(Storage::path('source')));

            $filteredFiles = array_filter($finderFile, function ($file) use ($committeeFileLink) {
                return $file->getFilename() === Str::replace('pdf', 'docx', (basename($committeeFileLink->public_path)));
            });

            if (count($filteredFiles) > 0) {
                $findPath = reset($filteredFiles)->getPath() . DIRECTORY_SEPARATOR . basename($committeeFileLink->public_path);
                Artisan::call('convert:path "' . FileUtility::correctDirectorySeparator(Str::replace('pdf', 'docx', $findPath)) . '" --output="' . $outputDirectory . '"');
                $pathForView = "/storage/committees/" . FileUtility::changeExtension(basename($committeeFileLink->public_path));
                $committeeFileLink->update([
                    'public_path' => $outputDirectory . basename(FileUtility::changeExtension($findPath)),
                ]);
            }
        }
    }

    return view('admin.committee.file-displays.show', [
        'filePathForView' => $pathForView,
    ]);
});


Route::get('/order-business-file/link/{uuid}', function (string $uuid) {
    $committeeFileLink = BoardSessionCommitteeLink::with('board_session')->where('uuid', $uuid)->first();
    $outputDirectory = FileUtility::publicDirectoryForViewing();

    if (!is_null($committeeFileLink->board_session)) {

        if (file_exists($committeeFileLink->board_session->file_path)) {
            Artisan::call('convert:path "' . FileUtility::correctDirectorySeparator($committeeFileLink->board_session->file_path) . '" --output="' . $outputDirectory . '"');
            $pathForView = "/storage/committees/" . FileUtility::changeExtension(basename($committeeFileLink->board_session->file_path));
        }
    } else {

        // check if file is exists
        if (file_exists($committeeFileLink->public_path)) {
            Artisan::call('convert:path "' . FileUtility::correctDirectorySeparator($committeeFileLink->public_path) . '" --output="' . $outputDirectory . '"');
            $pathForView = "/storage/committees/" . FileUtility::changeExtension(basename($committeeFileLink->public_path));
        } else {
            $finder = new Finder();
            $finderFile = iterator_to_array($finder->files()->in(Storage::path('source')));

            $filteredFiles = array_filter($finderFile, function ($file) use ($committeeFileLink) {
                return $file->getFilename() === Str::replace('pdf', 'docx', (basename($committeeFileLink->public_path)));
            });

            if (count($filteredFiles) > 0) {
                $findPath = reset($filteredFiles)->getPath() . DIRECTORY_SEPARATOR . basename($committeeFileLink->public_path);
                Artisan::call('convert:path "' . FileUtility::correctDirectorySeparator(Str::replace('pdf', 'docx', $findPath)) . '" --output="' . $outputDirectory . '"');
                $pathForView = "/storage/committees/" . FileUtility::changeExtension(basename($committeeFileLink->public_path));
                $committeeFileLink->update([
                    'public_path' => $outputDirectory . basename(FileUtility::changeExtension($findPath)),
                ]);
            }
        }
    }

    return view('admin.board-sessions.show', [
        'filePathForView' => $pathForView,
    ]);
});
