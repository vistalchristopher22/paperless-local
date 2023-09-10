<?php

namespace App\Http\Controllers\User;

use App\Models\Committee;
use App\Models\ReferenceSession;
use Illuminate\Support\Facades\DB;
use App\Pipes\Committee\UploadFile;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\AgendaRepository;
use Freshbitsweb\Laratables\Laratables;
use App\Pipes\Committee\CreateCommittee;
use App\Pipes\Committee\ExtractFileText;
use App\Pipes\Committee\UpdateCommittee;
use Illuminate\Support\Facades\Pipeline;
use App\Repositories\CommitteeRepository;
use App\Transformers\CommitteeLaraTables;
use App\Http\Requests\StoreCommitteeRequest;
use App\Http\Requests\UpdateCommitteeRequest;
use App\Pipes\Committee\MongoStoreInCollection;

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

        return view('user.committee.index', [
            'agendas' => $this->agendaRepository->get(),
            'availableRegularSessions' => $availableRegularSessions,
        ]);
    }

    public function create()
    {
        return view('user.committee.create', [
            'agendas' => $this->agendaRepository->getByIDs(UserRepository::accessibleAgendas(auth()->user())),
        ]);
    }

    public function store(StoreCommitteeRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $request->merge(['submitted_by' => auth()->user()->id]);
            Pipeline::send($request)
                ->through([
                    UploadFile::class,
                    CreateCommittee::class,
                    ExtractFileText::class,
                    MongoStoreInCollection::class,
                ])->then(fn ($data) => $data);

            return back()->with('success', 'Successfully created a committee.');
        });
    }

    public function edit(Committee $committee)
    {
        if (in_array($committee->lead_committee, auth()->user()->access->pluck('id')->toArray())) {
            return view('user.committee.edit', [
                'agendas' => $this->agendaRepository->getByIDs(UserRepository::accessibleAgendas(auth()->user())),
                'committee' => $committee,
            ]);
        }
        return abort(401);
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
}
