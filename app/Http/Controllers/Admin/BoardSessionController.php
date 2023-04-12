<?php

namespace App\Http\Controllers\Admin;

use App\Models\BoardSession;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Enums\BoardSessionStatus;
use App\Http\Requests\StoreRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Pipeline;
use App\Pipes\BoardSession\GetBoardSession;
use App\Pipes\BoardSession\DatatablesWrapper;
use App\Pipes\BoardSession\StoreBoardSession;
use App\Repositories\BoardSessionRespository;

final class BoardSessionController extends Controller
{

    public function __construct(private BoardSessionRespository $boardSessionRepository, private UserService $userService)
    {
        $this->middleware('verify.user')->only(['locked', 'unlocked', 'destroy']);
    }


    public function list()
    {
        return Pipeline::send([])
            ->through([
                GetBoardSession::class,
                DatatablesWrapper::class,
            ])->then(fn ($data) => $data);
    }

    public function index()
    {
        return view('admin.board-sessions.index');
    }


    public function create()
    {
        return view('admin.board-sessions.create');
    }


    public function store(StoreRequest $request)
    {
        return Pipeline::send($request->all())
            ->through([
                StoreBoardSession::class,
            ])->then(fn ($data) => redirect()->back()->with('success', 'Board session created successfully'));
    }


    public function show(string $id)
    {
        //
    }


    public function edit(int $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(BoardSession $board_session)
    {
        $this->boardSessionRepository->delete($board_session);
        return response()->json(['success' => 'Board session deleted successfully']);
    }

    public function locked(BoardSession $board_session)
    {
        $this->boardSessionRepository->locked($board_session);
        return response()->json(['success' => 'Board session locked successfully']);
    }

    public function unlocked(BoardSession $board_session)
    {
        $this->boardSessionRepository->unlocked($board_session);
        return response()->json(['success' => 'Board session unlocked successfully']);
    }

    public function unassignedBusinessStore(StoreRequest $request)
    {
        $this->boardSessionRepository->createUnassignedBusiness($request->all());
        return redirect()->back()->with('success', 'Unassigned business created successfully');
    }



    public function announcementStore(StoreRequest $request)
    {
        $this->boardSessionRepository->createAnnouncement($request->all());
        return redirect()->back()->with('success', 'Announcement created successfully');
    }
}
