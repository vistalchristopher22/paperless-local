<?php

namespace App\Http\Controllers\Admin;

use App\Models\Committee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CommitteeInvitedGuest;
use Illuminate\Support\Arr;

final class CommitteeInvitedGuestController extends Controller
{
    public function create(int $id)
    {
        return view('admin.committee.invited-guest.create', [
            'committee' => Committee::with(['lead_committee_information'])->find($id),
        ]);
    }

    public function store(Request $request, int $id)
    {
        return DB::transaction(function () use ($request, $id) {

            $committee = Committee::with(['committee_invited_guests'])->find($id);

            $submittedGuest = array_filter($request->guests ?? []);

            $committee->committee_invited_guests()->delete();

            $guests = [];

            Arr::map($submittedGuest, function ($guest) use (&$guests) {
                $guests[] = new CommitteeInvitedGuest([
                    'fullname' => $guest,
                ]);
            });


            $committee->invited_guests = 1;
            $committee->save();
            $committee->committee_invited_guests()->saveMany($guests);

            return back()->with('success', 'Guest successfully added');
        });
    }
}
