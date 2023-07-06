<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AgendaStoreRequest;
use App\Http\Requests\UpdateAgendaRequest;
use App\Models\Agenda;
use App\Repositories\AgendaRepository;
use App\Repositories\SanggunianMemberRepository;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function __construct(private AgendaRepository $agendaRepository, private SanggunianMemberRepository $sanggunianMemberRepository)
    {
    }

    public function index()
    {
        return view('admin.agendas.index', [
            'agendas' => $this->agendaRepository->get(),
        ]);
    }

    /**
     * It returns a view with a list of sangguniang panlalawigan members
     */
    public function create()
    {
        return view('admin.agendas.create', [
            'members' => $this->sanggunianMemberRepository->get(),
        ]);
    }

    /**
     * The store function takes a request object as a parameter, passes the request object to the
     * agendaRepository's store function, and then returns a success message
     *
     * @param Request request The request object.
     */
    public function store(AgendaStoreRequest $request)
    {
        $this->agendaRepository->store($request->except('_token'));

        return back()->with('success', 'Successfully add new committee agenda.');
    }

    /**
     * It returns the view of the edit page of the agenda.
     *
     * @param Agenda agenda The agenda object that will be edited.
     */
    public function edit(Agenda $agenda)
    {
        return view('admin.agendas.edit', [
            'members' => $this->sanggunianMemberRepository->get(),
            'agendaMembers' => $this->agendaRepository->getMembersId($agenda),
            'agenda' => $agenda,
        ]);
    }

    /**
     * It updates the agenda.
     *
     * @param UpdateAgendaRequest request The request object.
     * @param Agenda agenda The model instance that we are updating.
     */
    public function update(UpdateAgendaRequest $request, Agenda $agenda)
    {
        $this->agendaRepository->update($agenda, $request->except(['_token', '_method']));

        return back()->with('success', 'Comittee agenda successfully update.');
    }

    /**
     * The function reOrder() takes a request object as a parameter, and returns a json response
     *
     * @param Request request The request object
     * @return A JSON object with a key of success and a value of the result of the reOrderIndex
     * method.
     */
    public function reOrder(Request $request)
    {
        $result = $this->agendaRepository->reOrderIndex($request->all());

        return response()->json(['success' => $result]);
    }
}
