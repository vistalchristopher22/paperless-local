<?php

use App\Http\Controllers\Admin\Api\AgendaMemberController;
use App\Http\Controllers\Admin\Api\ScheduleController;
use App\Http\Controllers\Admin\CommitteeController as AdminCommitteeController;
use App\Models\Committee;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Route;

Route::get('committee-list/{lead?}/{expanded?}/{ids?}', [AdminCommitteeController::class, 'list'])->name('committee.list');
Route::get('agenda-members/{agenda}', [AgendaMemberController::class, 'members']);

Route::get('schedules', [ScheduleController::class, 'index'])->name('schedules.index');
Route::post('schedule', [ScheduleController::class, 'store'])->name('schedule.store');
Route::get('schedule/{id}', [ScheduleController::class, 'show'])->name('schedule.show');
Route::delete('schedule/{id}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');
Route::put('schedule-move/{schedule}', [ScheduleController::class, 'move'])->name('schedule.move');
Route::put('schedule', [ScheduleController::class, 'update'])->name('schedule.update');


Route::put('committee-approved', function () {
    $committee = Committee::find(request()->id);
    $committee->status = 'approved';
    $committee->save();

    return response()->json(['success' => true, 'sender' => $committee->submitted_by, 'committee' => $committee->id]);
});

Route::put('committee-returned', function () {
    $committee = Committee::find(request()->id);
    $committee->status = 'returned';
    $committee->returned_message = request()->message;
    $committee->save();

    return response()->json(['success' => true]);
});

Route::group(['prefix' => 'notifications'], function () {

    Route::post('user/push-notification', function () {
        $administrator = User::find(request()->administrator);
        $committee = Committee::with('lead_committee_information')->find(request()->committee);
        $created_at = now();
        $description = match (request()->event) {
            'committee_returned' => "The administrator returned your submitted committee named {$committee->lead_committee_information->title}",
            default => "The administrator approved your submitted committee named {$committee->lead_committee_information->title}",
        };

        UserNotification::updateOrCreate([
            'uuid' => request()->uuid,
            'user' => $committee->submitted_by,
            'submitted_by' => $administrator->id,
        ], [
            'user' => $committee->submitted_by,
            'submitted_by' => $administrator->id,
            'description' => $description,
            'created_at' => $created_at,
        ]);

        return response()->json([
            'success' => true,
            'description' => $description,
            'created_at' => $created_at->diffForHumans(),
            'sender' => $administrator,
        ]);
    });

    Route::post('push-notification', function () {
        $descriptions = [
            'committee_created' => 'New committee named :committee_name submitted by :user',
            'committee_update' => 'A submitted committee named :committee_name updated by :user',
        ];

        $sender = User::find(request()->submitted);
        $committee = Committee::with('lead_committee_information')->find(request()->committee);

        $description = null;
        $created_at = now();

        User::get()->except(request()->submitted)->each(function ($user) use ($sender, &$descriptions, &$description, $created_at, $committee) {

            $description = $descriptions[request()->event];

            $description = str_replace(':user', $sender->last_name.' '.$sender->first_name, $description);
            $description = str_replace(':committee_name', $committee?->lead_committee_information?->title, $description);

            UserNotification::updateOrCreate([
                'user' => $user->id,
                'submitted_by' => $sender->id,
                'uuid' => request()->uuid,
            ], [
                'user' => $user->id,
                'submitted_by' => $sender->id,
                'description' => $description,
                'created_at' => $created_at,
            ]);
        });

        return response()->json(['success' => true, 'sender' => $sender, 'description' => $description, 'created_at' => $created_at->diffForHumans()]);
    });
});
