<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Agenda;
use App\Http\Controllers\Controller;
use App\Repositories\AgendaRepository;
use App\Http\Requests\AgendaStoreRequest;
use App\Http\Requests\UpdateAgendaRequest;
use App\Repositories\SanggunianMemberRepository;

class AgendaController extends Controller
{
    public function __construct(private readonly AgendaRepository $agendaRepository, private readonly SanggunianMemberRepository $sanggunianMemberRepository)
    {
    }

    public function index()
    {
        return Inertia::render('ChairmanshipIndex', [
            'agendas'     => $this->agendaRepository->get()->load(['chairman_information', 'vice_chairman_information', 'members']),
            'sanggunians' => $this->agendaRepository->getDistinctedSanggunian(),
        ]);
    }

    public function create()
    {
        return Inertia::render('ChairmanshipCreate', [
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
        return Inertia::render('ChairmanshipEdit', [
            'members'       => $this->sanggunianMemberRepository->get(),
            'agendaMembers' => $this->agendaRepository->getMembersId($agenda),
            'agenda'        => $agenda,
        ]);
    }

    public function update(UpdateAgendaRequest $request, Agenda $agenda)
    {
        $this->agendaRepository->update($agenda, $request->except(['_token', '_method']));
        return back()->with('success', 'Agenda successfully updated.');
    }
}
