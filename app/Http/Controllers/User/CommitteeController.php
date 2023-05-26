<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pipes\Committee\GetCommittee;
use App\Repositories\AgendaRepository;
use Illuminate\Support\Facades\Pipeline;
use Yajra\DataTables\Facades\DataTables;
use App\Pipes\Committee\Filter\ContentFilter;
use App\Pipes\Committee\Filter\LeadCommitteeFilter;
use App\Pipes\Committee\Filter\ExpandedCommitteeFilter;

final class CommitteeController extends Controller
{

    public function __construct(private AgendaRepository $agendaRepository)
    {
    }


    public function list(mixed $lead = '*', mixed $expanded = '*', mixed $content = null)
    {
        return Pipeline::send([$lead, $expanded, $content])
            ->through([
                GetCommittee::class,
                LeadCommitteeFilter::class,
                ExpandedCommitteeFilter::class,
                ContentFilter::class
            ])->then(fn ($data) => DataTables::of($data)->make(true));
    }


    public function index()
    {
        return view('user.committee.index', [
            'agendas' => $this->agendaRepository->get()
        ]);
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
