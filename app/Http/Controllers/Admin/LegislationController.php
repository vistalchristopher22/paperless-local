<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Ordinance;
use App\Models\Legislation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\LegislationRepository;

final class LegislationController extends Controller
{
    public function __construct(private LegislationRepository $legislationRepository)
    {
    }


    public function index()
    {
        $legislations = Legislation::select('title', 'description', 'type')
                        ->where('type', 'resolution')
                        ->whereIn('title', ["Distinctio rerum quia consectetur consequuntur earum.", "Aut eveniet eos tempora aut."])
                        ->get();

        return view('admin.legislations.list', compact('legislations'));
    }


    public function create()
    {
        return view('admin.legislations.create');
    }


    public function store(Request $request)
    {

        $img = $request->file('attachment');
        $imgName = time(). '.' .$img->getClientOriginalName();
        $img->move(public_path('storage/approved-legislations/'), $imgName);
        $filePath = 'storage/approved-legislations/' . $imgName;


        //   for ($i = 1; $i <= 5; $i++) {
        //     $date = Carbon::now()->addDays($i);
        $ordinance = new Ordinance([
            'file' => $filePath . '.pdf',
            'author' => $request->author,
            'session_date' => $request->sessionDate
        ]);
        $ordinance->save();

        $legislation = new Legislation([
            'no' => 'ORD-' . str_pad(2, 5, '0', STR_PAD_LEFT),
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type
        ]);

        $legislation->legislable()->associate($ordinance);
        $legislation->save();
        // }


        return $legislation;
        // Return a response to the Ajax request
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Legislation created successfully!',
        // ]);
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
