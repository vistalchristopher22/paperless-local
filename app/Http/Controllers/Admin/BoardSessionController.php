<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Inertia\Inertia;
use App\Models\BoardSession;
use App\Models\ReferenceSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Pipes\BoardSession\FileUpload;
use App\Repositories\SettingRepository;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Support\Facades\Pipeline;
use App\Pipes\BoardSession\DeleteFileUpload;
use App\Transformers\BoardSessionLaraTables;
use App\Pipes\BoardSession\StoreBoardSession;
use App\Repositories\BoardSessionRespository;
use App\Pipes\BoardSession\DeleteBoardSession;
use App\Pipes\BoardSession\UpdateBoardSession;
use App\Http\Requests\StoreBoardSessionRequest;
use App\Http\Requests\UpdateBoardSessionRequest;
use App\Pipes\BoardSession\CreateWordDocumentContent;
use App\Pipes\BoardSession\UpdateWordDocumentContent;
use App\Pipes\BoardSession\ExtractTextFromWordDocument;
use App\Pipes\BoardSession\GeneratePDFDocumentForViewing;

final class BoardSessionController extends Controller
{
    public function __construct(private readonly BoardSessionRespository $boardSessionRepository)
    {
        $this->middleware('verify.user')->only(['locked', 'unlocked', 'destroy']);
    }

    public function list(): array
    {
        return Laratables::recordsOf(BoardSession::class, BoardSessionLaraTables::class);
    }

    /**
     * @throws Exception
     */
    public function index()
    {
        $boardSession = BoardSession::with(['schedule_information', 'schedule_information.regular_session'])->orderBy('created_at', 'DESC');
        return Inertia::render('BoardSessionIndex', [
            'boardSessions' => $boardSession->paginate(10),
            'availableRegularSessions' => ReferenceSession::has('scheduleSessions')->get()->unique('number'),
        ]);
    }

    public function create()
    {
        return view('admin.board-sessions.create');
    }

    public function store(StoreBoardSessionRequest $request)
    {
        return DB::transaction(function () use ($request) {
            return Pipeline::send($request->all())
                ->through([
                    StoreBoardSession::class,
                    FileUpload::class,
                    CreateWordDocumentContent::class,
                    ExtractTextFromWordDocument::class,
                ])->then(fn ($data) => redirect()->back()->with('success', 'Board session created successfully'));
        });
    }

    public function show(int $id)
    {
        $boardSession = $this->boardSessionRepository->findBy('id', $id);
        return redirect()->to($boardSession->file_link->view_link);
    }

    public function edit(int $id)
    {
        $boardSession = $this->boardSessionRepository->findBy('id', $id);
        return view('admin.board-sessions.edit', [
            'boardSession' => $boardSession,
        ]);
    }

    public function update(UpdateBoardSessionRequest $request, BoardSession $board_session)
    {
        return DB::transaction(function () use ($request, $board_session) {
            return Pipeline::send($request->merge(['boardSession' => $board_session])->all())
                ->through([
                    UpdateWordDocumentContent::class,
                    UpdateBoardSession::class,
                    FileUpload::class,
                    GeneratePDFDocumentForViewing::class,
                ])->then(fn ($data) => redirect()->back()->with('success', 'Board session updated successfully'));
        });
    }

    public function published(BoardSession $boardSession)
    {
        $boardSession->is_published = 1;
        $boardSession->save();
        return response()->json(['success' => true, 'message' => 'Session published successfully!']);
    }

    public function destroy(BoardSession $board_session)
    {
        DB::transaction(function () use ($board_session) {
            Pipeline::send($board_session)
                ->through([
                    DeleteBoardSession::class,
                    DeleteFileUpload::class,
                ])
                ->then(fn ($data) => $data);
        });

        return response()->json(['success' => true, 'message' => 'Board session deleted successfully']);
    }

    public function locked(BoardSession $board_session)
    {
        $this->boardSessionRepository->locked($board_session);

        return response()->json(['success' => true, 'message' => 'Board session locked successfully']);
    }

    public function unlocked(BoardSession $board_session)
    {
        $this->boardSessionRepository->unlocked($board_session);
        return response()->json(['success' => true, 'message' => 'Board session unlocked successfully']);
    }
}
