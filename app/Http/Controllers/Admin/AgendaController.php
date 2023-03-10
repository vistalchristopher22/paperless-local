<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AgendaStoreRequest;
use App\Repositories\AgendaRepository;
use App\Repositories\SanggunianMemberRepository;
use Illuminate\Http\Request;

class AgendaController extends Controller
{

    public function __construct(private AgendaRepository $agendaRepository, private SanggunianMemberRepository $sanggunianMemberRepository)
    {
        $this->middleware('convert.id.to.models')->only(['store', 'update']);
    }

    public function index()
    {
        return view('admin.agendas.index', [
            'agendas' => $this->agendaRepository->get(),
            'members' => "",
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
        $this->agendaRepository->store($request->all());
        return back()->with('success', 'Successfully add new committee agenda.');
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
