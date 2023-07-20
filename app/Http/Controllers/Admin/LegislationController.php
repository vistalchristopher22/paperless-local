<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Ordinance;
use App\Models\Legislation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\LegislationRepository;

final class LegislationController extends Controller
{
    public function __construct(private LegislationRepository $legislationRepository)
    {
    }


    /**
     * Retrieves a list of legislations from the database, including resolutions and ordinances,
     * and the names of corresponding authors (sanggunian members). Formats the data as a DataTable.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $legislations = DB::table('legislations')
            ->leftJoin('resolutions', 'legislations.legislable_id', '=', 'resolutions.id')
            ->leftJoin('ordinances', 'legislations.legislable_id', '=', 'ordinances.id')
            ->leftJoin('sanggunian_members', function ($join) {
                $join->on('resolutions.author', '=', 'sanggunian_members.id')
                    ->orOn('ordinances.author', '=', 'sanggunian_members.id');
            })
            ->select('legislations.no', 'legislations.title', 'legislations.description', 'legislations.type', 'sanggunian_members.fullname', 'resolutions.session_date as resolution_session_date', 'ordinances.session_date as ordinance_session_date')
            ->when(request('type'), function ($query, $type) {
                return $query->where('legislations.type', $type);
            })
            ->get();


        return DataTables::of($legislations)
            ->addColumn('session_date', function ($row) {
                return $row->resolution_session_date ?? $row->ordinance_session_date;
            })
            ->addColumn('action', function () {
                $btnEdit = '<a href="#" class="btn btn-sm btn-info" data-key="editBtn"><i class="bi bi-pen h5"></i> Edit</a>';
                $btnDelete = '<a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash h5"></i> Delete</a>';

                return $btnEdit . "&nbsp" . $btnDelete;
            })->make(true);
    }


    /**
     * Displays the index page for legislations in the admin panel.
     * Retrieves all records from the "legislations" table and passes the data to the view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $legislations = Legislation::select('title', 'description', 'type')
            ->where('type', 'resolution')
            ->whereIn('title', ["Distinctio rerum quia consectetur consequuntur earum.", "Aut eveniet eos tempora aut."])
            ->get();


        return view('admin.legislations.index', compact('legislations'));
    }


    public function create()
    {
        return view('admin.legislations.create');
    }


    public function store(Request $request)
    {

        $img = $request->file('attachment');
        $imgName = time() . '.' . $img->getClientOriginalName();
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
