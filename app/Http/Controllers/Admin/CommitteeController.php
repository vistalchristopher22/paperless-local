<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Committee;
use App\Models\ReferenceSession;
use Illuminate\Support\Facades\DB;
use App\Pipes\Committee\UnlinkFile;
use App\Pipes\Committee\UploadFile;
use App\Http\Controllers\Controller;
use App\Repositories\AgendaRepository;
use Freshbitsweb\Laratables\Laratables;
use App\Pipes\Committee\CreateCommittee;
use App\Pipes\Committee\DeleteCommittee;
use App\Pipes\Committee\ExtractFileText;
use App\Pipes\Committee\UpdateCommittee;
use Illuminate\Support\Facades\Pipeline;
use App\Transformers\CommitteeLaraTables;
use App\Http\Requests\StoreCommitteeRequest;
use App\Http\Requests\UpdateCommitteeRequest;
use App\Pipes\Committee\MongoStoreInCollection;
use App\Repositories\CommitteeRepository;

final class CommitteeController extends Controller
{
    public function __construct(private AgendaRepository $agendaRepository, private CommitteeRepository $committeeRepository)
    {
    }


    public function list()
    {
        return Laratables::recordsOf(Committee::class, CommitteeLaraTables::class);
    }


    public function index()
    {
        $availableRegularSessions = ReferenceSession::has('scheduleCommittees')->get()->unique('number');
        return Inertia::render('CommitteeIndex', [
            'committees' => $this->committeeRepository->paginated(),
            'agendas' => $this->agendaRepository->get()->load('chairman_information'),
            'availableRegularSessions' => $availableRegularSessions,
        ]);
    }

    public function create()
    {
        return Inertia::render('CommitteeCreate', [
            'agendas' => $this->agendaRepository->get(),
        ]);
    }


    public function store(StoreCommitteeRequest $request)
    {
        return DB::transaction(function () use ($request) {
            if (isset(auth()->user()->id)) {
                $request->merge(input: ['submitted_by' => auth()->user()->id]);
            }

            return Pipeline::send($request)
                ->through([
                    UploadFile::class,
                    CreateCommittee::class,
                    ExtractFileText::class,
                    MongoStoreInCollection::class,
                ])->then(fn ($data) => response()->json(['success' => true, 'message' => 'Committee created successfully.']));
        });
    }

    public function edit(Committee $committee)
    {
        return Inertia::render('CommitteeEdit', [
            'existingCommittee' => $committee,
            'agendas' => $this->agendaRepository->get(),
        ]);
    }

    public function update(UpdateCommitteeRequest $request, Committee $committee)
    {
        return DB::transaction(function () use ($request, $committee) {
            return Pipeline::send($request->merge(['committee' => $committee]))
                ->through([
                    UploadFile::class,
                    UpdateCommittee::class,
                    ExtractFileText::class,
                ])->then(fn () => response()->json(['success' => true, 'message' => 'Committee updated successfully.']));
        });
    }

    public function destroy(Committee $committee)
    {
        return DB::transaction(function () use ($committee) {
            Pipeline::send($committee)
                ->through([
                    DeleteCommittee::class,
                    UnlinkFile::class,
                ])->then(fn ($data) => $data);
            return back()->with('success', 'Committee deleted successfully.');
        });
    }
}
