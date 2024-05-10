<?php

use App\Models\User;
use App\Models\Committee;
use Illuminate\Http\Request;
use App\Models\ScreenDisplay;
use App\Models\UserNotification;
use App\Enums\ScreenDisplayStatus;
use Illuminate\Support\Facades\Route;
use App\Contracts\ScreenDisplayRepositoryInterface;
use App\Http\Controllers\Admin\Api\ScheduleController;
use App\Http\Controllers\Admin\UpdateCommitteeAttachment;
use App\Http\Controllers\Api\CommitteeScheduleController;
use App\Http\Controllers\Admin\Api\AgendaMemberController;
use App\Http\Controllers\Admin\BoardSessionAddScheduleController;
use App\Http\Controllers\Admin\UpdateOrderofBusinessAttachmentController;
use App\Http\Controllers\Admin\CommitteeController as AdminCommitteeController;

Route::put('screen/start/{id}', function (int $id) {
    $screenDisplay = tap(ScreenDisplay::where('status', ScreenDisplayStatus::ON_GOING)->find($id))->update([
        'start_time' => now(),
    ]);
    return response()->json(['start_time' => $screenDisplay->start_time]);
});

Route::put('screen/end/{id}', function (int $id) {
    $screenDisplay = tap(ScreenDisplay::with('reference_session')->where('status', ScreenDisplayStatus::ON_GOING)->find($id))->update([
        'end_time' => now(),
        'status' => ScreenDisplayStatus::DONE,
    ]);

    $newOnGoingData = tap(app()->make(ScreenDisplayRepositoryInterface::class)->getUpNextScreenDisplay($screenDisplay->reference_session))?->update([
        'status' => ScreenDisplayStatus::ON_GOING,
    ]);

    $upNextData = ScreenDisplay::where('index', ++$newOnGoingData->index)->update([
        'status' => ScreenDisplayStatus::NEXT,
    ]);

    return response()->json(['end_time' => $screenDisplay->end_time]);
});

Route::put('screen/repeat/{id}', function (int $id) {
    dd('no function in repeat');
    // $nextData = ScreenDisplay::where('status', ScreenDisplayStatus::NEXT)->update([
    //     'status' => ScreenDisplayStatus::PENDING,
    //     'end_time'  => null
    // ]);

    // $currentOnGoing = ScreenDisplay::where('status', ScreenDisplayStatus::ON_GOING)->update([
    //     'end_time' => null,
    //     'status' => ScreenDisplayStatus::NEXT,
    // ]);

    // $display = ScreenDisplay::find($id)->update([
    //     'status' => ScreenDisplayStatus::ON_GOING,
    //     'end_time' => null
    // ]);

    return response()->json(['success' => true]);
});

Route::put('screen/current', function (Request $request) {

    $onGoing = ScreenDisplay::where([
        'reference_session_id' => $request->reference_session_id,
        'status' => ScreenDisplayStatus::ON_GOING,
    ])->update([
        'status' => ScreenDisplayStatus::PENDING,
    ]);

    ScreenDisplay::where([
        'reference_session_id' => $request->reference_session_id,
        'screen_displayable_id' => $request->screen_displayable_id,
        'screen_displayable_type' => $request->screen_displayable_type,
        'schedule_id' => $request->schedule_id,
    ])->update([
        'status' => ScreenDisplayStatus::ON_GOING,
    ]);


    return response()->json(['success' => true]);
});

Route::put('screen/next', function (Request $request) {

    ScreenDisplay::where([
        'reference_session_id' => $request->reference_session_id,
        'status' => ScreenDisplayStatus::NEXT,
    ])->update([
        'status' => ScreenDisplayStatus::PENDING,
    ]);

    ScreenDisplay::where([
        'reference_session_id' => $request->reference_session_id,
        'screen_displayable_id' => $request->screen_displayable_id,
        'screen_displayable_type' => $request->screen_displayable_type,
        'schedule_id' => $request->schedule_id,
    ])->update([
        'status' => ScreenDisplayStatus::NEXT,
    ]);

    return response()->json(['success' => true]);
});


Route::get('committee-list/{lead?}/{expanded?}/{ids?}/{regularSession?}', [AdminCommitteeController::class, 'list'])->name('committee.list');
Route::get('agenda-members/{agenda}', [AgendaMemberController::class, 'members']);


Route::get('schedules', [ScheduleController::class, 'index'])->name('schedules.index');
Route::post('schedule', [ScheduleController::class, 'store'])->name('schedule.store');
Route::get('schedule/{id}', [ScheduleController::class, 'show'])->name('schedule.show');
Route::delete('schedule/{id}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');
Route::put('schedule-move/{schedule}', [ScheduleController::class, 'move'])->name('schedule.move');
Route::put('schedule', [ScheduleController::class, 'update'])->name('schedule.update');
Route::put('board-session/add-schedule', BoardSessionAddScheduleController::class);


Route::get('committee-schedule-information/{schedule}', [CommitteeScheduleController::class, 'show'])->name('committee-schedule-information.show');


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

            $description = str_replace(':user', $sender->last_name . ' ' . $sender->first_name, $description);
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


Route::get('committee-update-attachment/{id}', UpdateCommitteeAttachment::class);
Route::get('order-of-business-update-attachment/{id}', UpdateOrderofBusinessAttachmentController::class);
