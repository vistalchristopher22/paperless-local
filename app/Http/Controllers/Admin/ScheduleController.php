<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Enums\ScheduleType;
use App\Http\Controllers\Controller;
use App\Repositories\VenueRepository;
use App\Repositories\SettingRepository;
use App\Repositories\BoardSessionRespository;

final class ScheduleController extends Controller
{
    public function __construct(private readonly BoardSessionRespository $boardSessionRepository, private readonly VenueRepository $venueRepository)
    {
    }

    public function index()
    {
        return Inertia::render('ScheduleIndex', [
            'venues' => $this->venueRepository->get(),
            'upcomingSessions' => $this->boardSessionRepository->getNoScheduleEvents(),
            'regularSessions' => SettingRepository::getAvailableRegularSessionThisYear(),
            'scheduleTypes' => ScheduleType::values(),
            'ScheduleType' => ScheduleType::class,
        ]);
    }
}
