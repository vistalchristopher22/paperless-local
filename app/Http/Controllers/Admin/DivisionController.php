<?php

namespace App\Http\Controllers\Admin;

use App\Models\Division;
use App\Http\Controllers\Controller;
use App\Repositories\DivisionRepository;
use App\Http\Requests\DivisionStoreRequest;
use App\Http\Requests\DivisionUpdateRequest;
use App\Repositories\SanggunianMemberRepository;

class DivisionController extends Controller
{
    public function __construct(private DivisionRepository $divisionRepository, private SanggunianMemberRepository $sanggunianMemberRepository)
    {
    }

    public function index()
    {
        return view('admin.division.index', [
            'division' => $this->divisionRepository->get(),
        ]);
    }

    public function create()
    {
        return view('admin.division.create', [
            'members' => $this->sanggunianMemberRepository->get(),
        ]);
    }

    public function store(DivisionStoreRequest $request)
    {
        $this->divisionRepository->store($request->except('_token'));

        return back()->with('success', 'You have successfully added new division.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Division $division)
    {
        return view('admin.division.edit', [
            'division' => $division,
            'members' => $this->sanggunianMemberRepository->get(),
        ]);
    }

    public function update(DivisionUpdateRequest $request, Division $division)
    {
        $this->divisionRepository->update($division, $request->except(['_token', '_method']));
        return back()->with('success', 'You have successfully updated a division.');
    }

    public function destroy(Division $division)
    {
        $this->divisionRepository->delete($division);
        return back()->with('success', 'You have successfully deleted a division.');
    }
}