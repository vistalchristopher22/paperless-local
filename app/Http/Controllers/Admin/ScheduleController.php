<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\BoardSessionRespository;
use App\Repositories\VenueRepository;

final class ScheduleController extends Controller
{

    public function __construct(private readonly BoardSessionRespository $boardSessionRepository, private readonly VenueRepository $venueRepository)
    {
    }

    public function index()
    {
        return view('admin.schedules.index', [
            'venues' => $this->venueRepository->get(),
            'upcomingSessions' => $this->boardSessionRepository->getNoScheduleEvents(),
        ]);
    }
}
