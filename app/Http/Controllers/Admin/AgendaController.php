<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\AgendaRepository;
use Illuminate\Http\Request;

class AgendaController extends Controller
{

    public function __construct(private AgendaRepository $agendaRepository)
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
