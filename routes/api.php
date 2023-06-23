<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Committee;
use App\Models\UserNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\ScheduleResource;
use App\Http\Controllers\Admin\Api\AgendaMemberController;
use App\Http\Controllers\Admin\CommitteeController as AdminCommitteeController;

Route::get('committee-list', [AdminCommitteeController::class, 'list'])->name('committee.list');

Route::get('agenda-members/{agenda}', [AgendaMemberController::class, 'members']);

Route::post('schedule', function () {
    if (request()->time) {
        Carbon::parse(request()->selected_date . ' ' . request()->time);
    } else {
        Carbon::parse(request()->selected_date);
    }


    Schedule::create([
        'name' => request()->name,
        'date_and_time' => Carbon::parse(request()->selected_date . ' ' . request()->time),
        'description' => request()->description,
        'venue' => request()->venue,
        'with_invited_guest' => request()->guests == "on" ? 1 : 0,
        'type' => 'committee',
    ]);
    return response()->json(['success' => true]);
});

Route::put('schedule', function () {
    $schedule = Schedule::find(request()->id);

    $schedule->name = request()->name;
    $schedule->date_and_time = Carbon::parse(request()->selected_date . ' ' . request()->time);
    $schedule->description = request()->description;
    $schedule->venue = request()->venue;
    $schedule->with_invited_guest = request()->guests == "on" ? true : false;
    $schedule->save();

    return response()->json(['success' => true]);
});

Route::put('schedule-move/{id}', function ($id) {
    $newDate = request()->moveDate;
    $schedule = Schedule::find($id);
    $schedule->date_and_time = $newDate . ' ' . $schedule->date_and_time->format('H:i:00');
    $schedule->save();
    return response()->json(['success' => true, 'name' => $schedule->name, 'date' => $schedule->date_and_time->format('F d, Y')]);
});

Route::delete('schedule/{id}', function ($id) {
    return DB::transaction(function () use ($id) {
        $schedule = Schedule::with('committees')->find($id);

        $schedule->committees->each(function ($committee) {
            $committee->schedule_id = null;
            $committee->save();
        });
        $schedule->delete();

        return response()->json(['success' => true]);
    });
});

Route::get('schedule/{id}', function (int $id) {
    $data = Schedule::find($id);
    $data->time = Carbon::parse($data->date_and_time);
    $data->time = $data->time->format('H:i');
    return $data;
});

Route::get('schedules', function () {
    $data = ScheduleResource::collection(Schedule::get());
    return response()->json($data);
});

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
            'sender' => $administrator
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

            $description = str_replace(":user", $sender->last_name . ' ' . $sender->first_name, $description);
            $description = str_replace(":committee_name", $committee?->lead_committee_information?->title, $description);

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
