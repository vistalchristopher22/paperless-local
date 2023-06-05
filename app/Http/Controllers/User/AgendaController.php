<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\AgendaRepository;
use App\Repositories\SanggunianMemberRepository;

final class AgendaController extends Controller
{

    public function __construct(private AgendaRepository $agendaRepository, private SanggunianMemberRepository $sanggunianMemberRepository)
    {
        $this->middleware('convert.id.to.models')->only(['store', 'update']);

    }

    public function index()
    {
        return view('user.agendas.index', [
            'agendas' => $this->agendaRepository->get()
        ]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
