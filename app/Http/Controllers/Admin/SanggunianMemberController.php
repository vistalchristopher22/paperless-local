<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Models\SanggunianMember;
use App\Pipes\User\ProfilePicture;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Pipeline;
use App\Services\SanggunianMemberService;
use App\Repositories\SanggunianMemberRepository;
use App\Http\Requests\SanggunianMemberStoreRequest;
use App\Http\Requests\SanggunianMemberUpdateRequest;
use App\Pipes\SanggunianMember\StoreSanggunianMember;
use App\Pipes\SanggunianMember\UpdateSanggunianMember;

final class SanggunianMemberController extends Controller
{
    private UserService $userService;

    public function __construct(private SanggunianMemberRepository $sanggunianMemberRepository, private SanggunianMemberService $sanggunianMemberService)
    {
        $this->userService = app()->make(UserService::class);
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
        $pipe = Pipeline::send($request)->through([
            ProfilePicture::class,
            StoreSanggunianMember::class,
        ])->then(fn ($data) => $data);

        return back()->with('success', 'Successfully add new Sangguniang Panlalawigan Member');
    }

    public function edit(SanggunianMember $sanggunianMember)
    {
        return view('admin.sanggunian-members.edit', [
            'member' => $sanggunianMember,
        ]);
    }

    public function update(SanggunianMemberUpdateRequest $request, SanggunianMember $sanggunianMember)
    {
        Pipeline::send($request->merge(['sanggunianMember' => $sanggunianMember]))
            ->through([
                ProfilePicture::class,
                UpdateSanggunianMember::class,
            ])->then(fn ($data) => $data);

        return back()->with('success', 'Success! Sangguniang Panlalawigan Member updated successfully.');
    }

    public function destroy(SanggunianMember $sanggunianMember, Request $request)
    {
        if ($this->userService->verify($request->key, auth()->user())) {
            $this->sanggunianMemberRepository->delete($sanggunianMember);
            return response()->json(['success' => true, 'message' => 'Record deleted successfully, this page will automatically refresh after 5 seconds to apply the changes.']);
        }
        return response()->json(['success' => false, 'message' => 'The credentials you provide is invalid.'], 422);
    }
}
