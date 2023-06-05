<?php

use Carbon\Carbon;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\ScheduleResource;
use App\Http\Controllers\Admin\Api\AgendaMemberController;

Route::get('agenda-members/{agenda}', [AgendaMemberController::class, 'members']);

Route::post('schedule', function () {
    if(request()->time) {
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
    return response()->json(['success' => true]);
});

Route::delete('schedule/{id}', function ($id) {
    return DB::transaction(function () use($id) {
        $schedule = Schedule::with('committees')->find($id);

        $schedule->committees->each(function($committee) {
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
