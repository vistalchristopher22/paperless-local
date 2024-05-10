<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Enums\ScheduleType;
use App\Http\Controllers\Controller;
use App\Repositories\AgendaRepository;
use App\Repositories\VenueRepository;
use App\Repositories\SettingRepository;
use App\Repositories\BoardSessionRespository;

final class ScheduleController extends Controller
{
    private readonly AgendaRepository $agendaRepository;

    public function __construct(private readonly BoardSessionRespository $boardSessionRepository, private readonly VenueRepository $venueRepository)
    {
        $this->agendaRepository = app()->make(AgendaRepository::class);
    }

    public function index()
    {
        return Inertia::render('ScheduleIndex', [
            'venues'          => $this->venueRepository->get(),
            'orderOfBusiness' => $this->boardSessionRepository->getNoScheduleEvents(),
            'scheduleTypes'   => ScheduleType::values(),
            'ScheduleType'    => ScheduleType::class,
            'agendas'         => $this->agendaRepository->get(),
        ]);
    }
}
