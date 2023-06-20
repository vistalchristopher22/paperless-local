<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Committee;
use App\Models\SanggunianMember;
use Illuminate\Support\Facades\DB;
use App\Pipes\Committee\UploadFile;
use App\Http\Controllers\Controller;
use App\Pipes\Committee\GetCommittee;
use App\Repositories\AgendaRepository;
use App\Pipes\Committee\CreateCommittee;
use App\Pipes\Committee\ExtractFileText;
use App\Pipes\Committee\UpdateCommittee;
use Illuminate\Support\Facades\Pipeline;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\CommitteeRepository;
use Yajra\DataTables\Contracts\DataTable;
use App\Http\Requests\StoreCommitteeRequest;
use App\Http\Requests\UpdateCommitteeRequest;
use App\Pipes\Committee\Filter\ContentFilter;
use App\Pipes\Committee\Filter\LeadCommitteeFilter;
use App\Pipes\Committee\Filter\ExpandedCommitteeFilter;

final class CommitteeController extends Controller
{
    public function __construct(private CommitteeRepository $committeeRepository, private AgendaRepository $agendaRepository)
    {
    }

    /**
     * > The `list` function takes in a `lead` and `expanded` parameter, and returns a datatable of the
     * filtered committees
     *
     * @param mixed lead * = all
     * @param mixed expanded * = all
     * @param mixed content The content to filter by.
     *
     * @return A datatable of the filtered data.
     */
    public function list(mixed $lead = '*', mixed $expanded = '*', mixed $content = null)
    {
        return Pipeline::send([$lead, $expanded, $content])
            ->through([
                GetCommittee::class,
                // LeadCommitteeFilter::class,
                // ExpandedCommitteeFilter::class,
                // ContentFilter::class
            ])->then(fn ($data) => DataTables::of($data)->make(true));
    }

    /**
     * It returns a view called `admin.committee.index` with a variable called `agendas` that contains
     * the results of the `get()` function from the `AgendaRepository` class
     *
     * @return The view admin.committee.index and the agendas from the agendaRepository
     */
    public function index()
    {

        $commitees = Committee::with([
            'lead_committee_information', 'expanded_committee_information', 'lead_committee_information.chairman_information', 'lead_committee_information.vice_chairman_information', 'lead_committee_information.members', 'lead_committee_information.members.sanggunian_member',
            'expanded_committee_information.chairman_information', 'expanded_committee_information.vice_chairman_information', 'expanded_committee_information.members', 'expanded_committee_information.members.sanggunian_member', 'submitted'
        ]);

        if (array_key_exists('l', request()->query())) {
            $commitees->where('lead_committee', request()->query('l'));
        }

        if (array_key_exists('e', request()->query())) {
            $commitees->where('expanded_committee', request()->query('e'));
        }



        $commitees = $commitees->paginate(8);


        $maxYear = DB::table('committees')
            ->select(DB::raw('YEAR(MAX(date)) as max_year'))
            ->pluck('max_year')
            ->first();

        $minYear = DB::table('committees')
            ->select(DB::raw('YEAR(MIN(date)) as min_year'))
            ->pluck('min_year')
            ->first();

        $sangguniangMembers = SanggunianMember::get();

        return view('admin.committee.index', [
            'agendas' => $this->agendaRepository->get(),
            'committees' => $commitees,
            'sangguniangMembers' => $sangguniangMembers,
            'minYear' => $minYear,
            'maxYear' => $maxYear,
        ]);
    }

    /**
     * It returns a view with a priority number and agendas
     */
    public function create()
    {
        return view('admin.committee.create', [
            'priority_number' => $this->committeeRepository->getNextPriorityNumber(),
            'agendas' => $this->agendaRepository->get(),
        ]);
    }



    /**
     * > The `store` function takes a `StoreCommitteeRequest` object, sends it through a pipeline of
     * classes, and then returns a success message
     *
     * @param StoreCommitteeRequest request The request object.
     *
     * @return The data from the pipeline.
     */
    public function store(StoreCommitteeRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $request->merge(['submitted_by' => auth()->user()->id]);
            try {
                Pipeline::send($request)
                ->through([
                    UploadFile::class,
                    CreateCommittee::class,
                    ExtractFileText::class,
                ])->then(fn ($data) => $data);
            } catch(Exception $e) {
                dd($e->getMessage());
            }

            return back()->with('success', 'Successfully created a committee.');
        });
    }


    public function edit(Committee $committee)
    {
        return view('admin.committee.edit', [
            'committee' => $committee,
            'agendas' => $this->agendaRepository->get(),
        ]);
    }


    /**
     * > The `update` function takes a `UpdateCommitteeRequest` and a `Committee` model, and then sends
     * the request and the committee model through a pipeline of classes, and then returns the user to
     * the previous page with a success message
     *
     * @param UpdateCommitteeRequest request The request object
     * @param Committee committee The committee object that we're updating.
     *
     * @return The updated committee.
     */
    public function update(UpdateCommitteeRequest $request, Committee $committee)
    {
        return DB::transaction(function () use ($request, $committee) {
            Pipeline::send($request->merge(['committee' => $committee]))
                ->through([
                    UploadFile::class,
                    UpdateCommittee::class,
                    ExtractFileText::class,
                ])->then(fn ($data) => $data);
            return back()->with('success', 'Committee updated successfully.');
        });
    }
}
