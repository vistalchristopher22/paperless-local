<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Models\SanggunianMember;
use App\Pipes\User\ProfilePicture;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Pipeline;
use App\Repositories\SanggunianMemberRepository;
use App\Http\Requests\SanggunianMemberStoreRequest;
use App\Http\Requests\SanggunianMemberUpdateRequest;
use App\Pipes\SanggunianMember\StoreSanggunianMember;
use App\Pipes\SanggunianMember\UpdateSanggunianMember;

final class SanggunianMemberController extends Controller
{
    private UserService $userService;

    public function __construct(private SanggunianMemberRepository $sanggunianMemberRepository)
    {
        $this->userService = app()->make(UserService::class);
    }

    public function index()
    {
        return Inertia::render('SanggunianIndex', [
            'members' => $this->sanggunianMemberRepository->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('SanggunianCreate', [
            'members' => $this->sanggunianMemberRepository->get(),
        ]);
        // return view('admin.sanggunian-members.create');
    }

    public function store(SanggunianMemberStoreRequest $request)
    {
        return DB::transaction(function () use ($request) {
            return Pipeline::send($request)->through([
                ProfilePicture::class,
                StoreSanggunianMember::class,
            ])->then(fn ($data) => back()->with('success', 'Successfully add new Sangguniang Panlalawigan Member'));
        });
    }

    public function edit(SanggunianMember $sanggunianMember)
    {
        return Inertia::render('SanggunianEdit', [
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
        if (!is_null($request->key) && $this->userService->verify($request->key, auth()->user())) {
            $this->sanggunianMemberRepository->delete($sanggunianMember);

            return response()->json(['success' => true, 'message' => 'Record deleted successfully, this page will automatically refresh after 5 seconds to apply the changes.']);
        }

        return response()->json(['success' => false, 'message' => 'The credentials you provide is invalid.'], 422);
    }
}
