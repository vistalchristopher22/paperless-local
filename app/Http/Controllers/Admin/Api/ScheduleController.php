<?php

namespace App\Http\Controllers\Admin\Api;

use Carbon\Carbon;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Pipes\Schedule\CreateSchedule;
use App\Pipes\Schedule\UpdateSchedule;
use App\Http\Resources\ScheduleResource;
use App\Repositories\ScheduleRepository;
use Illuminate\Support\Facades\Pipeline;
use App\Http\Requests\ScheduleStoreRequest;

final class ScheduleController extends Controller
{
    public function __construct(private readonly ScheduleRepository $scheduleRepository)
    {
    }

    public function index()
    {
        return response()->json(data: ScheduleResource::collection($this->scheduleRepository->getAllSchedules()->loadCount('committees')));
    }

    public function store(ScheduleStoreRequest $request)
    {
        return DB::transaction(function () use ($request) {
            return Pipeline::send($request->all())
                ->through([
                    CreateSchedule::class,
                ])->then(fn ($scheduleID) => response()->json([
                    'success' => true,
                    'type'    => $request->type,
                    'id'      => $scheduleID
                ]));
        });
    }

    public function show(int $id)
    {
        $schedule       = $this->scheduleRepository->findBy(column: 'id', value: $id)->load('order_of_business_information')->loadCount('committees');
        $schedule->time = Carbon::parse($schedule->date_and_time);
        $schedule->time = $schedule->time->format('H:i');
        return $schedule;
    }

    public function move(Request $request, Schedule $schedule): JsonResponse
    {
        $this->scheduleRepository->update($schedule, [
            'date_and_time' => $request->moveDate . ' ' . $schedule->date_and_time->format('H:i:00'),
        ]);
        return response()->json(['success' => true]);
    }


    public function update(ScheduleStoreRequest $request)
    {
        return DB::transaction(function () use ($request) {
            return Pipeline::send($request->all())
                ->through([
                    UpdateSchedule::class,
                ])->then(fn () => response()->json(['success' => true]));
        });
    }

    public function destroy(int $id)
    {
        $result = $this->scheduleRepository->deleteSchedule($id);
        return response()->json(['success' => $result['isDeleted']]);
    }
}
