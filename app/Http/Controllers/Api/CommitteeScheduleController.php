<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Repositories\ScheduleRepository;
use Illuminate\Http\Request;

final class CommitteeScheduleController extends Controller
{
    public function __construct(private readonly ScheduleRepository $scheduleRepository)
    {}

    public function show(int $schedule)
    {
        $schedule = $this->scheduleRepository->findById($schedule);
        return response()->json(['schedule' => $schedule]);
    }
}
