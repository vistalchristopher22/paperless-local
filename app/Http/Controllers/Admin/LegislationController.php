<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Ordinance;
use App\Models\Resolution;
use App\Models\Legislation;
use App\Enums\LegislateType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
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
    public function list($dates)
    {

        $legislations = DB::table('legislations')
            ->leftJoin('resolutions', 'legislations.legislable_id', '=', 'resolutions.id')
            ->leftJoin('ordinances', 'legislations.legislable_id', '=', 'ordinances.id')
            ->leftJoin('sanggunian_members as sanggunian_members1', 'resolutions.author', '=', 'sanggunian_members1.id')
            ->leftJoin('sanggunian_members as sanggunian_members2', 'ordinances.author', '=', 'sanggunian_members2.id')
            ->select('legislations.id', 'legislations.no', 'legislations.title', 'legislations.description', 'legislations.classification', 'sanggunian_members1.fullname as resolution_author', 'sanggunian_members2.fullname as ordinance_author', 'resolutions.session_date as resolution_session_date', 'ordinances.session_date as ordinance_session_date', 'ordinances.type as ordinance_type', 'resolutions.type as resolution_type')
            ->when(request('classification'), function ($query, $classification) {
                return $query->where('legislations.classification', $classification);
            })
            ->orderBy('legislations.created_at', 'desc');


        if($dates == '*') {
            $legislations = $legislations->get();

        } else {
            // Convert dates from "MM-DD-YYYY - MM-DD-YYYY" to "YYYY-MM-DD - YYYY-MM-DD" format
            $datesArray = explode(' - ', $dates);
            $startDate = Carbon::createFromFormat('m-d-Y', $datesArray[0])->format('Y-m-d');
            $endDate = Carbon::createFromFormat('m-d-Y', $datesArray[1])->format('Y-m-d');

            $legislations = $legislations->when(function ($query) use ($startDate, $endDate) {
                return $query->where(function ($query) use ($startDate, $endDate) {
                    $query->whereDate('resolutions.session_date', '>=', $startDate)
                    ->whereDate('resolutions.session_date', '<=', $endDate)
                    ->orWhereDate('ordinances.session_date', '>=', $startDate)
                    ->whereDate('ordinances.session_date', '<=', $endDate);
                });
            })
            ->get();
        }


        return DataTables::of($legislations)
            ->addColumn('type', function ($row) {
                if($row->classification == "ordinance") {
                    $type = $row->ordinance_type;
                } else {
                    $type = $row->resolution_type;
                }
                return $type;
            })
            ->addColumn('session_date', function ($row) {
                if($row->classification == "ordinance") {
                    $classification = $row->ordinance_session_date;
                } else {
                    $classification = $row->resolution_session_date;
                }
                return $classification;
            })
            ->addColumn('author', function ($row) {
                if($row->classification == "ordinance") {
                    $author = $row->ordinance_author;
                } else {
                    $author = $row->resolution_author;
                }
                return $author;
            })
            ->addColumn('action', function ($row) {
                $btnEdit = '<a href=" '. route('legislation.edit', $row->id) .' " class="btn btn-sm btn-info" data-key="editBtn">
                            <i class="mdi mdi-pencil-outline"> Edit</i>
                            </a>';

                return $btnEdit;
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

        $classifications = LegislateType::values();

        $types = DB::table('types')->get();

        return view('admin.legislations.create', compact('sp_members', 'classifications', 'types'));
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

            if(LegislateType::ORDINANCE->value == $request->classification) {

                $docs = $request->file('attachment');
                $docName = uniqid().'.'.$docs->getClientOriginalName();
                $docs = Storage::disk('public')->putFileAs('source/Approved-Legislation/Ordinance', $docs, $docName);

                $ordinance = new Ordinance([
                    'file' => $docs,
                    'author' => $request->author,
                    'type' => $request->type,
                    'session_date' => $request->sessionDate
                ]);
                $ordinance->save();

                $data = DB::table('legislations')->where('classification', LegislateType::ORDINANCE->value)->count();

                $legislation = new Legislation([
                    'no' => 'ORD-' . str_pad($data + 1, 4, '0', STR_PAD_LEFT),
                    'title' => $request->title,
                    'description' => $request->description,
                    'classification' => $request->classification
                ]);

                $legislation->legislable()->associate($ordinance);
                $legislation->save();

            } else {

                $docs = $request->file('attachment');
                $docName = uniqid().'.'.$docs->getClientOriginalName();
                $docs = Storage::disk('public')->putFileAs('source/Approved-Legislation/Resolution', $docs, $docName);

                $resolution = new Resolution([
                    'file' => $docs,
                    'author' => $request->author,
                    'type'  => $request->type,
                    'session_date' => $request->sessionDate
                ]);
                $resolution->save();

                $data = DB::table('legislations')->where('classification', LegislateType::RESOLUTION->value)->count();

                $legislation = new Legislation([
                    'no' => 'RES-' . str_pad($data + 1, 4, '0', STR_PAD_LEFT),
                    'title' => $request->title,
                    'description' => $request->description,
                    'classification' => $request->classification
                ]);
                $legislation->legislable()->associate($resolution);
                $legislation->save();
            }
        });

        return back()->with('success', 'You have successfully created.');
    }



    public function show(string $id)
    {
        //
    }



    /**
     * Retrieve the legislation data with its associated legislable model
     * (Resolution or Ordinance) and their author and session_date.
     * Prepare the required data (author options) from the sp_members table.
     * Then, load the edit view with the retrieved data and options.
     *
     * @param string $id The ID of the legislation to be edited.
     * @return \Illuminate\View\View The edit view with data and options.
     */
    public function edit(string $id)
    {
        $data = Legislation::with('legislable')->find($id);

        if ($data->legislable_type === 'App\Models\Resolution') {
            $author = $data->legislable->author;
            $typeValue = $data->legislable->type;
            $sessionDate = $data->legislable->session_date;
            $attachment = $data->legislable->file;

        } elseif ($data->legislable_type === 'App\Models\Ordinance') {

            $author = $data->legislable->author;
            $typeValue = $data->legislable->type;
            $sessionDate = $data->legislable->session_date;
            $attachment = $data->legislable->file;
        }

        $sp_members = DB::table('sanggunian_members')
                    ->leftJoin('resolutions', 'sanggunian_members.id', '=', 'resolutions.author')
                    ->leftJoin('ordinances', 'sanggunian_members.id', '=', 'ordinances.author')
                    ->select('sanggunian_members.id as sp_id', 'sanggunian_members.fullname as sp_fullname')
                    ->get();


        $classifications = LegislateType::values();

        $types = DB::table('types')->get('name');

        return view('admin.legislations.edit', compact('data', 'author', 'sessionDate', 'attachment', 'typeValue', 'sp_members', 'classifications', 'types'));
    }


    /**
     * Update the Legislation and its associated Ordinance or Resolution based on the provided request data.
     *
     * This method allows updating the details of an existing Legislation record along with its associated
     * Ordinance or Resolution, depending on the 'type' provided in the request. If the 'type' is 'Ordinance',
     * the associated Ordinance will be updated with the provided data, including the attached file if any.
     * If the 'type' is 'Resolution', the associated Resolution will be updated accordingly.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {

        $legislation = Legislation::findOrFail($id);

        DB::transaction(function () use ($request, $legislation) {

            if ($legislation->classification === LegislateType::ORDINANCE->value) {

                $ordinance = $legislation->legislable;
                $ordinance->author = $request->author;
                $ordinance->type = $request->type;
                $ordinance->session_date = $request->sessionDate;

                if ($request->hasFile('attachment')) {
                    $docs = $request->file('attachment');
                    $docName = uniqid() . '.' . $docs->getClientOriginalName();
                    $docs = Storage::disk('public')->putFileAs('source/Approved-Legislation/Ordinance', $docs, $docName);
                    $ordinance->file = $docs;
                }

                $ordinance->save();

            } else {

                $resolution = $legislation->legislable;
                $resolution->author = $request->author;
                $resolution->type = $request->type;
                $resolution->session_date = $request->sessionDate;

                if ($request->hasFile('attachment')) {
                    $docs = $request->file('attachment');
                    $docName = uniqid() . '.' . $docs->getClientOriginalName();
                    $docs = Storage::disk('public')->putFileAs('source/Approved-Legislation/Resolution', $docs, $docName);
                    $resolution->file = $docs;
                }

                $resolution->save();
            }

            // Update the Legislation details
            $legislation->classification = $request->classification;
            $legislation->title = $request->title;
            $legislation->description = $request->description;
            $legislation->save();
        });

        return back()->with('success', 'You have successfully updated.');
    }



    public function destroy(string $id)
    {
        //
    }

}
