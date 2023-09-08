<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Committee;
use App\Models\CommitteeInvitedGuest;
use Illuminate\Http\Request;

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
        $committee = Committee::with(['committee_invited_guests'])->find($id);

        $submittedGuest = array_filter($request->guests ?? []);

        $committee->committee_invited_guests()->delete();

        $guests = [];

        foreach($submittedGuest as $guest) {
            $guests[] = new CommitteeInvitedGuest([
                'fullname' => $guest,
            ]);
        }

        $committee->committee_invited_guests()->saveMany($guests);

        return back()->with('success', 'Guest successfully added');
    }
}
