<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ordinance;
use App\Models\Resolution;
use App\Models\Legislation;
use App\Enums\LegislateType;
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
        $data = Legislation::get();

        return view('admin.legislations.index', compact('data'));
    }


    /**
     * Displays the create form for adding a new legislation in the admin panel.
     * Retrieves a list of sanggunian members and the possible types of legislation,
     * then passes this data to the view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $sp_members = DB::table('sanggunian_members')->select('id', 'fullname')->get();

        $types = LegislateType::values();

        return view('admin.legislations.create', compact('sp_members', 'types'));
    }


    /**
     * Stores (creates) a new legislation based on the data from the user's request.
     * Handles creating either an "Ordinance" or a "Resolution" record, along with associated "Legislation" records.
     * Manages file uploads for each legislation type (Ordinance or Resolution).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => ['required'],
            'description' => ['required'],
            'attachment' => ['required'],
        ]);

        DB::transaction(function () use ($request) {

            if(LegislateType::ORDINANCE->value == $request->type) {

                $img = $request->file('attachment');
                $imgName = time().'.'.$img->getClientOriginalName();
                $img->move(public_path('storage/source/Approved-Legislation/Ordinance'), $imgName);

                $ordinance = new Ordinance([
                    'file' => $img.'.pdf',
                    'author' => $request->author,
                    'session_date' => $request->sessionDate
                ]);
                $ordinance->save();

                $data = DB::table('legislations')->where('type', LegislateType::ORDINANCE->value)->count();

                $legislation = new Legislation([
                    'no' => 'ORD-' . str_pad($data, 4, '0', STR_PAD_LEFT),
                    'title' => $request->title,
                    'description' => $request->description,
                    'type' => $request->type
                ]);

                $legislation->legislable()->associate($ordinance);
                $legislation->save();

            } else {

                $img = $request->file('attachment');
                $imgName = time().'.'.$img->getClientOriginalName();
                $img->move(public_path('storage/source/Approved-Legislation/Resolution'), $imgName);


                $resolution = new Resolution([
                    'file' => $img . '.pdf',
                    'author' => $request->author,
                    'session_date' => $request->sessionDate
                ]);
                $resolution->save();

                $data = DB::table('legislations')->where('type', LegislateType::RESOLUTION->value)->count();

                $legislation = new Legislation([
                    'no' => 'RES-' . str_pad($data, 4, '0', STR_PAD_LEFT),
                    'title' => $request->title,
                    'description' => $request->description,
                    'type' => $request->type
                ]);
                $legislation->legislable()->associate($resolution);
                $legislation->save();
            }
        });


        return back()->with('success', 'Successfully updated.');
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
