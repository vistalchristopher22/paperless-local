<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Schedule;
use App\Models\Committee;
use App\Models\LoginHistory;
use App\Enums\CommitteeStatus;
use App\Http\Controllers\Controller;

final class HomeController extends Controller
{
    public function index()
    {

        $reviewCommittees = Committee::where('status', CommitteeStatus::REVIEW->value)->count();

        $returnedCommittees = Committee::where('status', CommitteeStatus::RETURN->value)->count();

        $todaysSchedule = Schedule::where('type', 'committee')
            ->whereDate('date_and_time', Carbon::today())
            ->count();

        $activeUsers = User::where('is_online', true)->get()
            ->except(auth()->user()->id)
            ->count();

        $loginHistories = LoginHistory::with('user')->orderBy('logged_in_at', 'DESC')->paginate(5, ['*'], 'loginHistoryPage');

        $submittedCommittees = Committee::with(['lead_committee_information', 'expanded_committee_information', 'submitted'])
            ->where('status', CommitteeStatus::REVIEW->value)
            ->paginate(5, ['*'], 'submittedCommitteesPage');

        return Inertia::render('Home', [
            'reviewCommittees'             => $reviewCommittees,
            'returnedCommittees'           => $returnedCommittees,
            'todaysSchedule'               => $todaysSchedule,
            'activeUsers'                  => $activeUsers,
            'loginHistories'               => $loginHistories,
            'submittedCommittees'          => $submittedCommittees,
        ]);
    }
}
