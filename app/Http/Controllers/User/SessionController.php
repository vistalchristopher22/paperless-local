<?php

namespace App\Http\Controllers\User;

use App\Models\BoardSession;
use Illuminate\Http\Request;
use App\Models\ReferenceSession;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Pipes\BoardSession\FileUpload;
use App\Repositories\SettingRepository;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Support\Facades\Pipeline;
use App\Transformers\BoardSessionLaraTables;
use App\Pipes\BoardSession\StoreBoardSession;
use App\Pipes\BoardSession\UpdateBoardSession;
use App\Http\Requests\StoreBoardSessionRequest;
use App\Http\Requests\UpdateBoardSessionRequest;
use App\Pipes\BoardSession\CreateWordDocumentContent;
use App\Pipes\BoardSession\UpdateWordDocumentContent;
use App\Pipes\BoardSession\ExtractTextFromWordDocument;
use App\Pipes\BoardSession\GeneratePDFDocumentForViewing;

final class SessionController extends Controller
{
    public function list()
    {
        return Laratables::recordsOf(BoardSession::class, BoardSessionLaraTables::class);
    }

    public function index()
    {
        return view('user.session.index', [
            'availableRegularSessions' => ReferenceSession::has('scheduleSessions')->get()->unique('number'),
            'settingsMissingStatus' => SettingRepository::getSettingsForBoardSession(),
        ]);
    }

    public function create()
    {
        return view('user.session.create');
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
                ])->then(fn ($data) => redirect()->back()->with('success', 'Order of business created successfully'));
        });
    }

    public function edit(BoardSession $session)
    {
        return view('user.session.edit', [
            'boardSession' => $session,
        ]);
    }

    
    public function update(UpdateBoardSessionRequest $request, BoardSession $session)
    {
        return DB::transaction(function () use ($request, $session) {
            return Pipeline::send($request->merge(['boardSession' => $session])->all())
                ->through([
                    UpdateWordDocumentContent::class,
                    UpdateBoardSession::class,
                    FileUpload::class,
                    GeneratePDFDocumentForViewing::class,
                ])->then(fn ($data) => redirect()->back()->with('success', 'Order of business updated successfully'));
        });
    }


}
