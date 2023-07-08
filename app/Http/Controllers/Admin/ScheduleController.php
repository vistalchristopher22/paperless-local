<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\VenueRepository;

final class ScheduleController extends Controller
{
    public function index(VenueRepository $venueRepository)
    {
        return view('admin.schedules.index', [
            'venues' => $venueRepository->get(),
        ]);
    }
}
