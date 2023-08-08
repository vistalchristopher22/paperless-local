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
    public function __construct(private readonly AgendaRepository $agendaRepository, private readonly SanggunianMemberRepository $sanggunianMemberRepository)
    {
    }

    public function index()
    {
        return view('admin.agendas.index', [
            'agendas' => $this->agendaRepository->get(),
        ]);
    }

    public function create()
    {
        return view('admin.agendas.create', [
            'members' => $this->sanggunianMemberRepository->get(),
        ]);
    }

    public function store(AgendaStoreRequest $request)
    {
        $this->agendaRepository->store($request->except('_token'));
        return back()->with('success', 'Agenda created successfully');
    }


    public function edit(Agenda $agenda)
    {
        return view('admin.agendas.edit', [
            'members' => $this->sanggunianMemberRepository->get(),
            'agendaMembers' => $this->agendaRepository->getMembersId($agenda),
            'agenda' => $agenda,
        ]);
    }

    public function update(UpdateAgendaRequest $request, Agenda $agenda)
    {
        $this->agendaRepository->update($agenda, $request->except(['_token', '_method']));
        return back()->with('success', 'Agenda successfully updated.');
    }

    public function reOrder(Request $request)
    {
        $result = $this->agendaRepository->reOrderIndex($request->all());
        return response()->json(['success' => $result]);
    }
}
