<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommitteeRequest;
use App\Http\Requests\UpdateCommitteeRequest;
use App\Models\Committee;
use App\Pipes\Committee\CreateCommittee;
use App\Pipes\Committee\ExtractFileText;
use App\Pipes\Committee\MongoStoreInCollection;
use App\Pipes\Committee\UpdateCommittee;
use App\Pipes\Committee\UploadFile;
use App\Repositories\AgendaRepository;
use App\Repositories\CommitteeRepository;
use App\Transformers\CommitteeLaraTables;
use Exception;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Pipeline;

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
     * @return A datatable of the filtered data.
     */
    public function list()
    {
        return Laratables::recordsOf(Committee::class, CommitteeLaraTables::class);
    }

    /**
     * It returns a view called `admin.committee.index` with a variable called `agendas` that contains
     * the results of the `get()` function from the `AgendaRepository` class
     *
     * @return The view admin.committee.index and the agendas from the agendaRepository
     */
    public function index()
    {
        return view('admin.committee.index', [
            'agendas' => $this->agendaRepository->get(),
        ]);
    }

    /**
     * It returns a view with a priority number and agendas
     */
    public function create()
    {
        return view('admin.committee.create', [
            'agendas' => $this->agendaRepository->get(),
        ]);
    }

    /**
     * > The `store` function takes a `StoreCommitteeRequest` object, sends it through a pipeline of
     * classes, and then returns a success message
     *
     * @param StoreCommitteeRequest request The request object.
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
                        MongoStoreInCollection::class,
                    ])->then(fn ($data) => $data);
            } catch (Exception $e) {
                Log::info($e->getMessage());
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
