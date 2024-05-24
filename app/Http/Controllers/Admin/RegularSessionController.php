<?php

namespace App\Http\Controllers\Admin;

use App\Models\Schedule;
use App\Models\ReferenceSession;
use App\Http\Controllers\Controller;
use App\Repositories\ReferenceSessionRepository;
use App\Repositories\ScheduleRepository;

final class RegularSessionController extends Controller
{
    protected ScheduleRepository $scheduleRepository;
    public function __construct(private readonly ReferenceSessionRepository $referenceSessionRepository)
    {
        $this->scheduleRepository = app()->make(ScheduleRepository::class);
    }

    public function index()
    {
        return inertia('RegularSessionIndex', [
            'schedules' => $this->scheduleRepository->getAllSchedules()
                ->load(['schedule_venue', 'order_of_business_information'])
                ->loadCount('committees'),
        ]);
        // return view('admin.regular-sessions.index', [
        // 'schedules' => $this->scheduleRepository->getAllSchedules(),
        // ]);
    }

    public function show(int $id)
    {
        $referenceSession = ReferenceSession::with(['scheduleCommittees.committees', 'scheduleCommittees.committees.lead_committee_information', 'scheduleSessions.board_sessions'])->find($id);
        return view('admin.regular-sessions.show', compact('referenceSession'));
    }
}
