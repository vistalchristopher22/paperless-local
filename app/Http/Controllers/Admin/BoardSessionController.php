<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoardSession;
use App\Pipes\BoardSession\DatatablesWrapper;
use App\Pipes\BoardSession\DeleteBoardSession;
use App\Pipes\BoardSession\DeleteFileUpload;
use App\Pipes\BoardSession\FileUpload;
use App\Pipes\BoardSession\GetBoardSession;
use App\Pipes\BoardSession\StoreBoardSession;
use App\Pipes\BoardSession\UpdateBoardSession;
use App\Repositories\BoardSessionRespository;
use App\Resolvers\PDFLinkResolver;
use App\Services\DocumentService;
use App\Services\UserService;
use App\Utilities\CommitteeFileUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Pipeline;

final class BoardSessionController extends Controller
{
    private DocumentService $documentService;

    public function __construct(private BoardSessionRespository $boardSessionRepository, private readonly UserService $userService)
    {
        $this->documentService = app()->make(DocumentService::class);
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

    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            return Pipeline::send($request->all())
                ->through([
                    StoreBoardSession::class,
                    FileUpload::class,
                ])->then(fn ($data) => redirect()->back()->with('success', 'Board session created successfully'));
        });
    }

    public function show(int $id)
    {
        $boardSession = $this->boardSessionRepository->findBy('id', $id);
        $filePath = CommitteeFileUtility::correctDirectorySeparator($boardSession->file_path);

        $fileName = basename($filePath);

        $outputDirectory = CommitteeFileUtility::publicDirectoryForViewing();

        Artisan::call('convert:path "' . $filePath . '" --output="' . $outputDirectory . '"');

        $pathForView = CommitteeFileUtility::generatePathForViewing($outputDirectory, $fileName);

        new PDFLinkResolver(CommitteeFileUtility::publicDirectoryForViewing() . CommitteeFileUtility::changeExtension($fileName));

        return view('admin.board-sessions.show', [
            'filePathForView' => $pathForView
        ]);
    }

    public function edit(int $id)
    {
        $boardSession = $this->boardSessionRepository->findBy('id', $id);
        return view('admin.board-sessions.edit', compact('boardSession'));
    }

    public function update(Request $request, BoardSession $board_session)
    {
        return Pipeline::send($request->merge(['boardSession' => $board_session])->all())
            ->through([
                UpdateBoardSession::class,
                FileUpload::class,
            ])->then(fn ($data) => redirect()->back()->with('success', 'Board session updated successfully'));
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
