<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;
use App\Repositories\DivisionRepository;
use App\Http\Requests\DivisionStoreRequest;
use App\Http\Requests\DivisionUpdateRequest;

class DivisionController extends Controller
{

    public function __construct(private DivisionRepository $divisionRepository)
    {
    }


    public function index()
    {
        return view('admin.division.index', [
            'division' => $this->divisionRepository->get()
        ]);
    }


    public function create()
    {
        return view('admin.division.create');
    }


    public function store(DivisionStoreRequest $request)
    {
        $this->divisionRepository->store($request->all());

        return back()->with('success', 'You have successfully added new division.');
    }


    public function show(string $id)
    {
        //
    }


    public function edit(Division $division)
    {
        return view('admin.division.edit', [
            'division' => $division
        ]);
    }


    public function update(DivisionUpdateRequest $request, Division $division)
    {
        $this->divisionRepository->update($division, $request->all());

        return back()->with('success', 'You have successfully updated a division.');
    }


    public function destroy(Division $division)
    {
        $this->divisionRepository->delete($division);

        return back()->with('success', 'You have successfully deleted a division.');
    }
}
