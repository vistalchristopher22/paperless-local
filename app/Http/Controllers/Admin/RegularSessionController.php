<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReferenceSession;
use App\Repositories\ReferenceSessionRepository;

final class RegularSessionController extends Controller
{
    public function __construct(private readonly ReferenceSessionRepository $referenceSessionRepository)
    {

    }
    public function index()
    {
        return view('admin.regular-sessions.index', [
            'referenceSessions' => $this->referenceSessionRepository->get()->load(['scheduleCommittees', 'scheduleSessions'])
        ]);
    }

    public function show(int $id)
    {
        $referenceSession = ReferenceSession::with(['scheduleCommittees.committees', 'scheduleCommittees.committees.lead_committee_information', 'scheduleSessions.board_sessions'])->find($id);
        return view('admin.regular-sessions.show', compact('referenceSession'));
    }
}
