<?php

use App\Models\User;
use App\Models\Venue;
use App\Models\Setting;
use App\Models\Schedule;
use App\Models\Committee;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Utilities\CommitteeFileUtility;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VenueController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\Archive\FileBulkDeleteController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\CommitteeController;
use App\Http\Controllers\Admin\UserAccessController;
use App\Http\Controllers\Admin\Archive\FileController;
use App\Http\Controllers\Admin\Archive\FilePreviewController;
use App\Http\Controllers\Admin\Archive\FileShowInExplorerController;
use App\Http\Controllers\Admin\BoardSessionController;
use App\Http\Controllers\Admin\CommitteeFileController;
use App\Http\Controllers\SPMember\SPMCommitteeController;
use App\Http\Controllers\Admin\SanggunianMemberController;
use App\Http\Controllers\Admin\SubmittedCommitteeController;
use App\Http\Controllers\Admin\SanggunianMemberAgendaController;
use App\Http\Controllers\Admin\CommitteeMeetingScheduleController;
use App\Http\Controllers\Admin\CommitteeMeetingSchedulePrintController;
use App\Http\Controllers\Admin\CommitteeMeetingSchedulePreviewController;

Route::redirect('/', '/login');
Auth::routes();
Route::get('submitted-committee/list', SubmittedCommitteeController::class);
Route::get('home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'features:administrator'], function () {
        Route::group(['model' => User::class], fn () => Route::resource('account', UserController::class));

        Route::resource('venue', VenueController::class);

        Route::resource('account-access-control', UserAccessController::class);

        Route::get('sanggunian-member/{member}/agendas/show', SanggunianMemberAgendaController::class)->name('sanggunian-member.agendas.show');
        Route::resource('sanggunian-members', SanggunianMemberController::class);
        Route::post('re-order/agenda', [AgendaController::class, 'reOrder'])->name('agenda.re-order');
        Route::resource('agendas', AgendaController::class);

        Route::resource('division', DivisionController::class);

        Route::get('schedule-add-committee/{id}', function ($scheduleID) {
            $schedule = Schedule::findOrFail($scheduleID);
            return view('admin.committee-meeting.edit', [
                'schedule' => $schedule,
            ]);
        })->name('schedule.add.committee');

        Route::get('schedule-merge-committee/{dates}/print', function (string $dates) {
            $dates = explode("&", $dates);
            $schedules = Schedule::with(['committees', 'committees.lead_committee_information', 'committees.expanded_committee_information'])
                ->whereIn(DB::raw('CONVERT(date, date_and_time)'), $dates)
                ->orderBy('date_and_time', 'ASC')
                ->orderBy('with_invited_guest', 'DESC')
                ->get()
                ->groupBy(function ($record) {
                    return $record->date_and_time->format('Y-m-d');
                });

            $settings = Setting::whereIn('name', ['prepared_by', 'noted_by'])->get();

            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->setOption('header-html', view('admin.committee-meeting.print-header'));
            $pdf->loadView('admin.committee-meeting.print', compact('settings', 'schedules'))
                ->setPaper('legal')
                ->setOption('enable-local-file-access', true)
                ->setOrientation('portrait');

            return $pdf->stream();
        })->name('schedule-meeting.merge.print');


        Route::get('schedule-merge-committee/{dates}', function (string $dates) {
            $dates = explode("&", $dates);
            $schedules = Schedule::with(['committees', 'committees.lead_committee_information', 'committees.expanded_committee_information'])
                ->whereIn(DB::raw('CONVERT(date, date_and_time)'), $dates)
                ->orderBy('with_invited_guest', 'DESC')
                ->orderBy('date_and_time', 'ASC')
                ->get()
                ->groupBy(function ($record) {
                    return $record->date_and_time->format('Y-m-d');
                });

            $settings = Setting::whereIn('name', ['prepared_by', 'noted_by'])->get();

            return view('admin.committee-meeting.edit-bulk', [
                'schedules' => $schedules,
                'settings' => $settings,
                'dates' => implode('&', $dates),
            ]);
        });

        Route::post('committee-add-schedule', function (Request $request) {
            $committee = Committee::find($request->id);
            $committee->schedule_id = $request->parent;
            $committee->save();
            if ($request->has('order')) {
                foreach ($request->order as $commmitteID) {
                    foreach ($commmitteID as $orderIndex => $id) {
                        $committee = Committee::find($id);
                        $committee->display_index = ($orderIndex + 1);
                        $committee->save();
                    }
                }
            }
            return response()->json(['success' => true]);
        });

        Route::resource('schedules', CommitteeMeetingController::class)->only('index');
        Route::resource('committee-file', CommitteeFileController::class)->only(['show', 'edit']);


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
            Route::post('archive/details', [FileController::class, 'show'])->name('file.show');
            Route::post('archive/rename', [FileController::class, 'update'])->name('file.update');
            Route::post('archive/upload', [FileController::class, 'store'])->name('file.store');
            Route::delete('archive/delete', [FileController::class, 'destroy'])->name('file.delete');
        });

        Route::post('/admin/files/filter/type', [FileController::class, 'getFileByTypes']);

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

// SB MEMBER
Route::group(['prefix' => 'sb-member', 'middleware' => ['auth', 'features:sb-member']], function () {
    // Route::get('sbm-committees', [SPMCommitteeController::class, 'index'])->name('sbm.committee.index');
    // Route::get('sbm-committees', [SPMCommitteeController::class, 'index'])->name('sbm.committee.index');
    // Route::get('sbm-committees', [SPMCommitteeController::class, 'index'])->name('sbm.committee.index');
});

Route::get('show-attachment/{url}/{location}', function (string $file, string $location) {
    $location = str_replace('-', '/', $location);
    $extension = pathinfo($file, PATHINFO_EXTENSION);
    $path = $location . '/' . $file;
    $path = CommitteeFileUtility::fixTemporaryForwardSlashSeparator($path);
    $outputDirectory = CommitteeFileUtility::publicDirectoryForViewing();
    if (in_array($extension, CommitteeFileUtility::CONVERTIBLE_FILE_EXTENSIONS)) {
        Artisan::call('convert:path "' . $path . '" --output="' . $outputDirectory . '"');
    } else {
        $path = Str::after($path, 'storage');
        $path = CommitteeFileUtility::correctDirectorySeparator(base_path() . '/storage' . $path);
        copy($path, $outputDirectory . $file);
    }

    $pathForView = CommitteeFileUtility::generatePathForViewing($outputDirectory, $file);
    $basePath = base_path();
    $escaped_path = escapeshellarg(CommitteeFileUtility::publicDirectoryForViewing() . CommitteeFileUtility::changeExtension($file));
    shell_exec("python.exe $basePath\\reader.py -f $escaped_path");

    return view('testing', [
        'filePathForView' => $pathForView,
    ]);
})->name('show-attachment');


Route::get('display-schedule-merge-committee/{dates}', function (string $dates) {
    $dates = explode("&", $dates);
    $schedules = Schedule::with(['committees', 'committees.lead_committee_information', 'committees.expanded_committee_information'])
        ->whereIn(DB::raw('CONVERT(date, date_and_time)'), $dates)
        ->orderBy('with_invited_guest', 'DESC')
        ->orderBy('date_and_time', 'ASC')
        ->get()
        ->groupBy(function ($record) {
            return $record->date_and_time->format('Y-m-d');
        });

    // $settings = Setting::whereIn('name', ['prepared_by', 'noted_by'])->get();
    return view('committee-meeting', [
        'schedules' => $schedules,
        // 'settings' => $settings,
        'dates' => implode('&', $dates),
    ]);
})->name('display.published.meeting');


// Route for SP-Member
Route::get('sp-committee-sched-meeting/{dates}', function (string $dates) {
    $dates = date('Y-m-d H:i:s');
    $dates = explode("&", $dates);
    // dd($dates);

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
