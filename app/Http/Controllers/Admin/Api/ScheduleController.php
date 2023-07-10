<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Repositories\ScheduleRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

final class ScheduleController extends Controller
{
    public function __construct(private ScheduleRepository $scheduleRepository)
    {
    }

    public function index()
    {
        return response()->json($this->scheduleRepository->getAllSchedules());
    }

    public function store(Request $request)
    {
        $this->scheduleRepository->createSchedule($request->all());
        return response()->json(['success' => true]);
    }

    public function show(int $id)
    {
        $schedule = $this->scheduleRepository->findBy(column: 'id', value: $id);
        $schedule->time = Carbon::parse($schedule->date_and_time);
        $schedule->time = $schedule->time->format('H:i');
        return $schedule;
    }

    public function move(Request $request, Schedule $schedule)
    {
        $this->scheduleRepository->update($schedule, [
            'date_and_time' => $request->moveDate . ' ' . $schedule->date_and_time->format('H:i:00'),
        ]);
        return response()->json(['success' => true, 'name' => $schedule->name, 'date' => $schedule->date_and_time->format('F d, Y')]);
    }


    public function update(Request $request)
    {
        $this->scheduleRepository->updateSchedule($request->all());

        return response()->json(['success' => true]);
    }

    public function destroy(int $id)
    {
        $isSuccess = $this->scheduleRepository->deleteSchedule($id);
        return response()->json(['success' => $isSuccess]);
    }
}
