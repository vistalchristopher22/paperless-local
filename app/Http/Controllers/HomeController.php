<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Committee;
use Illuminate\Support\Str;
use App\Models\LoginHistory;
use App\Enums\CommitteeStatus;
use Illuminate\Support\Facades\DB;

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

            $loginHistories = LoginHistory::with('user')->get();

            $committeeStatusTotal = Committee::select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get();
            $committeeStatus = $committeeStatusTotal->pluck('status')->toArray();
            $committeeStatusValues = $committeeStatusTotal->pluck('total')->toArray();


            $committeesPastSevenDays = Committee::select(DB::raw('CONVERT(date, created_at) as date'), DB::raw('COUNT(*) as total'))
                ->where('created_at', '>=', Carbon::now()->subDays(6))
                ->groupBy(DB::raw('CONVERT(date, created_at)'))
                ->get();


            $dates = [];
            for ($i = 0; $i < 7; $i++) {
                $dates[] = Carbon::now()->subDays($i)->format('Y-m-d');
            }

            $labels = $committeesPastSevenDays->pluck('date')->map(fn ($row) => $row->format('Y-m-d'))->toArray();
            $values = $committeesPastSevenDays->pluck('total')->toArray();


            $merged = array_unique(array_merge($dates, $labels));

            $data = array_fill_keys($merged, 0);
            foreach ($committeesPastSevenDays as $item) {
                $date = $item->date->format('Y-m-d');
                $data[$date] = (int) $item->total ?? 0;
            }

            ksort($data);

            $committeePastSevenDaysLabels = array_keys($data);
            $committeePastSevenDaysValues = array_values($data);
        }

        return match (true) {
            $user && $user->active('administrator') => view('home', compact('committees', 'reviewCommittees', 'returnedCommittees', 'todaysSchedule', 'activeUsers', 'loginHistories', 'committeeStatus', 'committeeStatusValues', 'committeePastSevenDaysLabels', 'committeePastSevenDaysValues')),
            $user && $user->active('user') => view('user.dashboard'),
            default => abort(404),
        };
    }
}
