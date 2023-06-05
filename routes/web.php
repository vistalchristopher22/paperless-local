<?php

use App\Models\User;
use App\Models\Setting;
use App\Models\Schedule;
use App\Models\Committee;
use App\Models\BoardSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CommitteeController;
use App\Http\Controllers\Admin\UserAccessController;
use App\Http\Controllers\Admin\BoardSessionController;
use App\Http\Controllers\Admin\Archieve\FileController;
use App\Http\Controllers\Admin\CommitteeFileController;
use App\Http\Controllers\Admin\CommitteeMeetingController;
use App\Http\Controllers\Admin\SanggunianMemberController;
use App\Http\Controllers\Admin\SanggunianMemberAgendaController;
use App\Http\Controllers\User\CommitteeController as UserCommitteeController;

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

        Route::resource('committee-meeting', CommitteeMeetingController::class);
        Route::resource('committee-file', CommitteeFileController::class);
        Route::get('committee-list/{lead?}/{expanded?}/{content?}', [CommitteeController::class, 'list'])->name('committee.list');

        Route::resource('committee', CommitteeController::class);

        Route::get('board-sessions/list', [BoardSessionController::class, 'list'])->name('board-sessions.list');
        Route::post('board-sessions/locked/{board_session}', [BoardSessionController::class, 'locked'])->name('board-sessions.locked');
        Route::post('board-sessions/unlocked/{board_session}', [BoardSessionController::class, 'unlocked'])->name('board-sessions.unlocked');

        Route::group(['base_rule' => 'order_business', 'model' => BoardSession::class], fn () => Route::resource('board-sessions', BoardSessionController::class));

        Route::post('files/get', [FileController::class, 'getFiles']);
        Route::resource('files', FileController::class);

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings/update', [SettingController::class, 'update'])->name('settings.update');
    });

    Route::get('edit-information', [AccountController::class, 'edit'])->name('information.edit');
    Route::put('edit-information', [AccountController::class, 'update'])->name('information.update');
});


Route::group(['prefix' => 'user', 'middleware' => ['auth', 'features:user']], function () {
    Route::get('user-committees', [UserCommitteeController::class, 'index'])->name('user.committee.index');
});

Route::get('sample', function () {
    return view('testing');
});
