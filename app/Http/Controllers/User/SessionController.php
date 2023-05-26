<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Pipeline;
use Yajra\DataTables\Facades\DataTables;
use App\Pipes\BoardSession\GetBoardSession;


final class SessionController extends Controller
{

    public function list()
    {

        return Pipeline::send([])
            ->through([
                GetBoardSession::class,
            ])->then(fn($data) => DataTables::of($data))
                ->editColumn('created_at', function ($boardSession) {
                    return $boardSession->created_at->format('F d, Y h:i A');
                })
                ->addColumn('action', function($row) {
                    return '<a href="' . route('board-sessions.show', $row->id) . '" class="btn btn-sm btn-primary text-white shadow"><i class="fas fa-eye"></i>&nbsp; View</a>';
                })
                ->addColumn('published', function ($row) {
                    if ($row->is_published == 1) {
                        return '<span class="badge bg-success text-uppercase">Yes</span>';
                    } else {
                        return '<span class="badge bg-primary text-uppercase">No</span>';
                    }
                })
            ->rawColumns(['action', 'published'])
            ->make(true);
    }


    public function index()
    {
        return view('user.session.index');
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
