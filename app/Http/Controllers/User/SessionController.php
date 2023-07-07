<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Pipes\BoardSession\GetBoardSession;
use Illuminate\Support\Facades\Pipeline;
use Yajra\DataTables\Facades\DataTables;

final class SessionController extends Controller
{
    public function list()
    {
        return Pipeline::send([])
            ->through([
                GetBoardSession::class,
            ])->then(fn ($data) => DataTables::of($data))
            ->editColumn('created_at', fn ($boardSession) => $boardSession->created_at->format('F d, Y h:i A'))
            ->addColumn('action', fn ($row) => "<button class='btn btn-primary btn-view-file' data-path='{$row->file_path}'><i class='mdi mdi-eye-outline'></i>&nbsp; View</button>")
            ->addColumn('published', fn ($row) => ($row->is_published == 1) ? '<span class="badge bg-success text-uppercase">Yes</span>' : '<span class="badge bg-primary text-uppercase">No</span>')
            ->rawColumns(['action', 'published'])
            ->make(true);
    }

    public function index()
    {
        return view('user.session.index');
    }
}
