<?php

namespace App\Http\Controllers\User;

use App\Models\Committee;
use App\Models\ReferenceSession;
use Illuminate\Support\Facades\DB;
use App\Pipes\Committee\UploadFile;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Pipes\Committee\GetCommittee;
use App\Repositories\AgendaRepository;
use App\Pipes\Committee\CreateCommittee;
use App\Pipes\Committee\ExtractFileText;
use App\Pipes\Committee\UpdateCommittee;
use Illuminate\Support\Facades\Pipeline;
use App\Repositories\CommitteeRepository;
use App\Http\Requests\StoreCommitteeRequest;
use App\Http\Requests\UpdateCommitteeRequest;
use App\Pipes\Committee\MongoStoreInCollection;
use App\Pipes\Committee\User\DatatablesWrapper;
use App\Pipes\Notification\NotifyCreatedCommittee;
use App\Pipes\Notification\NotifyUpdatedCommittee;

final class CommitteeController extends Controller
{
    public function __construct(private AgendaRepository $agendaRepository, private CommitteeRepository $committeeRepository)
    {
    }

    public function list()
    {
        return Pipeline::send([])
            ->through([
                GetCommittee::class,
                DataTablesWrapper::class,
            ])->then(fn ($data) => $data);
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
        return view('user.committee.edit', [
            'agendas' => $this->agendaRepository->getByIDs(UserRepository::accessibleAgendas(auth()->user())),
            'committee' => $committee,
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
}
