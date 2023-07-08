<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\VenueRepository;
use Illuminate\Http\Request;

final class VenueController extends Controller
{
    public function store(Request $request, VenueRepository $venueRepository)
    {
        $this->validate($request, [
            'name' => 'unique:venues',
        ]);

        $venueRepository->store($request->all());
        return response()->json(['success' => true]);
    }
}
