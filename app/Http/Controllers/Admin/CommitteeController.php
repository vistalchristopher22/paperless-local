<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommitteeRequest;
use App\Http\Requests\UpdateCommitteeRequest;
use App\Models\Committee;
use App\Models\ReferenceSession;
use App\Pipes\Committee\CreateCommittee;
use App\Pipes\Committee\DeleteCommittee;
use App\Pipes\Committee\ExtractFileText;
use App\Pipes\Committee\MongoStoreInCollection;
use App\Pipes\Committee\UnlinkFile;
use App\Pipes\Committee\UpdateCommittee;
use App\Pipes\Committee\UploadFile;
use App\Repositories\AgendaRepository;
use App\Transformers\CommitteeLaraTables;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Pipeline;

final class CommitteeController extends Controller
{
    public function __construct(private AgendaRepository $agendaRepository)
    {
    }


    public function list()
    {
        return Laratables::recordsOf(Committee::class, CommitteeLaraTables::class);
    }


    public function index()
    {
        $availableRegularSessions = ReferenceSession::has('scheduleCommittees')->get()->unique('number');
        return view('admin.committee.index', [
            'agendas' => $this->agendaRepository->get(),
            'availableRegularSessions' => $availableRegularSessions,
        ]);
    }

    public function create()
    {
        return view('admin.committee.create', [
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
                ])->then(fn ($data) => back()->with('success', 'Successfully created a committee.'));
        });
    }

    public function edit(Committee $committee)
    {
        return view('admin.committee.edit', [
            'committee' => $committee,
            'agendas' => $this->agendaRepository->get(),
        ]);
    }

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
