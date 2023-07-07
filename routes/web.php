<?php

use App\Models\User;
use App\Models\Venue;
use App\Models\Setting;
use App\Models\Schedule;
use App\Models\Committee;
use Illuminate\Support\Str;
use App\Models\BoardSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VenueController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\CommitteeController;
use App\Http\Controllers\Admin\UserAccessController;
use App\Http\Controllers\Admin\BoardSessionController;
use App\Http\Controllers\Admin\Archieve\FileController;
use App\Http\Controllers\Admin\CommitteeFileController;
use App\Http\Controllers\SPMember\SPMCommitteeController;
use App\Http\Controllers\Admin\CommitteeMeetingController;
use App\Http\Controllers\Admin\SanggunianMemberController;
use App\Http\Controllers\Admin\SanggunianMemberAgendaController;

Route::redirect('/', '/login');

Auth::routes();

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


        Route::resource('committee', CommitteeController::class);

        Route::get('board-sessions/list', [BoardSessionController::class, 'list'])->name('board-sessions.list');
        Route::post('board-sessions/locked/{board_session}', [BoardSessionController::class, 'locked'])->name('board-sessions.locked');
        Route::post('board-sessions/unlocked/{board_session}', [BoardSessionController::class, 'unlocked'])->name('board-sessions.unlocked');

        Route::group(['base_rule' => 'order_business', 'model' => BoardSession::class], fn () => Route::resource('board-sessions', BoardSessionController::class));

        Route::post('/admin/archive/process/show-in-explorer', [FileController::class, 'show']);
        Route::post('/admin/archive/process/upload', [FileController::class, 'upload']);
        Route::post('/admin/archive/process/details', [FileController::class, 'getFileInformation']);
        Route::post('/admin/archive/process/preview', [FileController::class, 'preview']);
        Route::get('/admin/archive/files/get-files', [FileController::class, 'getFiles']);
        Route::post('/admin/archive/file/rename', [FileController::class, 'renameFile']);
        Route::delete('/admin/archive/file/delete', [FileController::class, 'deleteFile']);
        Route::delete('/admin/archive/file/delete/bulk', [FileController::class, 'deleteBulk']);
        Route::resource('files', FileController::class);

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings/update', [SettingController::class, 'update'])->name('settings.update');
    });

    Route::get('edit-information', [AccountController::class, 'edit'])->name('information.edit');
    Route::put('edit-information', [AccountController::class, 'update'])->name('information.update');
});



// SB MEMBER
Route::group(['prefix' => 'sb-member', 'middleware' => ['auth', 'features:sb-member']], function () {
    // Route::get('sbm-committees', [SPMCommitteeController::class, 'index'])->name('sbm.committee.index');
    // Route::get('sbm-committees', [SPMCommitteeController::class, 'index'])->name('sbm.committee.index');
    // Route::get('sbm-committees', [SPMCommitteeController::class, 'index'])->name('sbm.committee.index');
});

Route::get('show-attachment/{file}/{location}', function (string $file, string $location) {
    $location = str_replace("..", DIRECTORY_SEPARATOR, $location);

    $extension = pathinfo($file, PATHINFO_EXTENSION);

    $originalExtension = Str::reverse($extension);

    $fileName = str_replace($extension, $originalExtension, $file);

    if (!Str::contains($location, "C:")) {
        $location = "C:{$location}";
    }

    $completePath = str_replace($file, $fileName, $location);

    $toConvertExtension = ['xls', 'xlsx', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'gif'];

    if (in_array($originalExtension, $toConvertExtension)) {
        Log::info('convert => ' . $fileName . ' to PDF');

        shell_exec('"C:\Program Files\LibreOffice\program\soffice" --headless --convert-to pdf "' . $completePath . '" --outdir ' . public_path("storage\\copy-files\\"));

        $viewPath  = "storage" . DIRECTORY_SEPARATOR . "copy-files" . DIRECTORY_SEPARATOR . str_replace($originalExtension, "pdf", $fileName);
    } else {
        // Using this complete path we can now copy the file and paste to copy-files directory in public/storage for viewing purposes.
        if (File::exists($completePath)) {
            File::copy($completePath, public_path("storage/copy-files/" . $fileName));
            $viewPath  = "storage" . DIRECTORY_SEPARATOR . "copy-files" . DIRECTORY_SEPARATOR . $fileName;
        } else {
            throw new Exception("File on {$completePath} not found!");
        }
    }


    return view('testing', [
        'filePathForView' => $viewPath,
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


Route::post('store-venue', function(Request $request) {

    Venue::create([
        'name' => $request->name
    ]);

    return response()->json(['success' => true]);
});
