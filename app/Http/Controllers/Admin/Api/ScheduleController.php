<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\ReferenceSession;
use App\Models\Schedule;
use App\Pipes\ReferenceSession\CreateIfNotExistsReferenceSession;
use App\Pipes\Schedule\AddGuests;
use App\Pipes\Schedule\CreateSchedule;
use App\Pipes\Schedule\GenerateRegularSessionChildDirectories;
use App\Pipes\Schedule\GenerateRegularSessionDirectory;
use App\Pipes\Schedule\UpdateSchedule;
use App\Repositories\ScheduleRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Pipeline;

final class ScheduleController extends Controller
{
    public function __construct(private readonly ScheduleRepository $scheduleRepository)
    {
    }

    public function index()
    {
        return response()->json(data: $this->scheduleRepository->getAllSchedules());
    }

    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            return Pipeline::send($request->all())
                ->through([
                    CreateIfNotExistsReferenceSession::class,
                    GenerateRegularSessionDirectory::class,
                    GenerateRegularSessionChildDirectories::class,
                    CreateSchedule::class,
                    AddGuests::class,
                ])->then(fn ($scheduleID) => response()->json(['success' => true, 'type' => $request->type, 'id' =>
                    $scheduleID]));
        });
    }

    public function show(int $id)
    {
        $schedule = $this->scheduleRepository->findBy(column: 'id', value: $id)->load(['regular_session:id,number,year', 'guests:id,schedule_id,fullname']);
        $schedule->time = Carbon::parse($schedule->date_and_time);
        $schedule->time = $schedule->time->format('H:i');
        return $schedule;
    }

    public function move(Request $request, Schedule $schedule): JsonResponse
    {
        $this->scheduleRepository->update($schedule, [
            'date_and_time' => $request->moveDate . ' ' . $schedule->date_and_time->format('H:i:00'),
        ]);
        return response()->json(['success' => true, 'name' => $schedule->name, 'date' => $schedule->date_and_time->format('F d, Y')]);
    }


    public function update(Request $request)
    {
        return DB::transaction(function () use ($request) {
            return Pipeline::send($request->all())
                ->through([
                    CreateIfNotExistsReferenceSession::class,
                    UpdateSchedule::class,
                    AddGuests::class,
                ])->then(fn ($scheduleID) => response()->json(['success' => true]));
        });
    }

    public function destroy(int $id)
    {
        return response()->json(['success' => $this->scheduleRepository->deleteSchedule($id)]);
    }
}
