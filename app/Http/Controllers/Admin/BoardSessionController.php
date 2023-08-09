<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBoardSessionRequest;
use App\Http\Requests\UpdateBoardSessionRequest;
use App\Models\BoardSession;
use App\Models\ReferenceSession;
use App\Pipes\BoardSession\CreateWordDocumentContent;
use App\Pipes\BoardSession\DeleteBoardSession;
use App\Pipes\BoardSession\DeleteFileUpload;
use App\Pipes\BoardSession\FileUpload;
use App\Pipes\BoardSession\StoreBoardSession;
use App\Pipes\BoardSession\UpdateBoardSession;
use App\Pipes\BoardSession\UpdateWordDocumentContent;
use App\Repositories\BoardSessionRespository;
use App\Repositories\SettingRepository;
use App\Resolvers\PDFLinkResolver;
use App\Transformers\BoardSessionLaraTables;
use App\Utilities\FileUtility;
use Exception;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Pipeline;

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
    public function index(): View
    {
        return view('admin.board-sessions.index', [
            'availableRegularSessions' => ReferenceSession::has('scheduleSessions')->get()->unique('number'),
            'settingsMissingStatus' => SettingRepository::getSettingsForBoardSession(),
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
                ])->then(fn ($data) => redirect()->back()->with('success', 'Board session created successfully'));
        });
    }

    public function show(int $id)
    {
        $boardSession = $this->boardSessionRepository->findBy('id', $id);
        $filePath = FileUtility::correctDirectorySeparator($boardSession->file_path);

        $fileName = basename($filePath);

        $outputDirectory = FileUtility::publicDirectoryForViewing();

        Artisan::call('convert:path "' . $filePath . '" --output="' . $outputDirectory . '"');

        $pathForView = FileUtility::generatePathForViewing($outputDirectory, $fileName);

        new PDFLinkResolver(FileUtility::publicDirectoryForViewing() . FileUtility::changeExtension($fileName));

        return view('admin.board-sessions.show', [
            'filePathForView' => $pathForView
        ]);
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
