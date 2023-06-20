<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Committee;
use App\Enums\CommitteeStatus;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()?->user()?->features();

        if ($user && $user->active('administrator')) {
            $reviewCommittees = Committee::where('status', CommitteeStatus::REVIEW->value)->count();
            $returnedCommittees = Committee::where('status', CommitteeStatus::RETURN->value)->count();
            $todaysSchedule = Schedule::where('type', 'committee')
                                    ->whereDate('date_and_time', Carbon::today())
                                    ->count();
            $activeUsers = User::where('is_online', true)->get()
                                    ->except(auth()->user()->id)
                                    ->count();
            $committees = Committee::with(['lead_committee_information', 'expanded_committee_information', 'submitted'])->where('status', 'review')->get();
        }

        return match (true) {
            $user && $user->active('administrator') => view('home', compact('committees', 'reviewCommittees', 'returnedCommittees', 'todaysSchedule', 'activeUsers')),
            $user && $user->active('user') => view('user.dashboard'),
            default => abort(404),
        };
    }
}
