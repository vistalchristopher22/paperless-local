<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SanggunianMemberRepository;
use App\Http\Requests\SanggunianMemberStoreRequest;
use App\Http\Requests\SanggunianMemberUpdateRequest;
use App\Models\SanggunianMember;

final class SanggunianMemberController extends Controller
{

    public function __construct(private SanggunianMemberRepository $sanggunianMemberRepository)
    {
    }


    public function index()
    {
        return view('admin.sanggunian-members.index', [
            'members' => $this->sanggunianMemberRepository->get(),
        ]);
    }


    public function create()
    {
        return view('admin.sanggunian-members.create');
    }


    public function store(SanggunianMemberStoreRequest $request)
    {
        $this->sanggunianMemberRepository->store([
            'name'       => $request->fullname,
            'district'   => $request->district,
            'sanggunian' => $request->sanggunian,
        ]);

        return redirect()->back()->with('success', 'Successfully add new Sangguniang Panlalawigan Member');
    }



    public function edit(SanggunianMember $sanggunianMember)
    {
        return view('admin.sanggunian-members.edit', [
            'member' => $sanggunianMember
        ]);
    }


    public function update(SanggunianMemberUpdateRequest $request, SanggunianMember $sanggunianMember)
    {
        $this->sanggunianMemberRepository->update($sanggunianMember, [
            'name'       => $request->fullname,
            'district'   => $request->district,
            'sanggunian' => $request->sanggunian,
        ]);

        return back()->with('success', 'Success! Sangguniang Panlalawigan Member updated successfully.');
    }


    public function destroy(SanggunianMember $sanggunianMember)
    {
        $this->sanggunianMemberRepository->delete($sanggunianMember);
        return back()->with('success', 'Successfully delete a record');
    }
}