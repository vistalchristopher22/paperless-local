<?php

namespace App\Http\Controllers\Admin;

use App\Models\Committee;
use App\Pipes\Committee\UploadFile;
use App\Http\Controllers\Controller;
use App\Repositories\AgendaRepository;
use App\Pipes\Committee\CreateCommittee;
use App\Pipes\Committee\ExtractFileText;
use App\Pipes\Committee\UpdateCommittee;
use Illuminate\Support\Facades\Pipeline;
use App\Repositories\CommitteeRepository;
use App\Http\Requests\StoreCommitteeRequest;
use App\Http\Requests\UpdateCommitteeRequest;

final class CommitteeController extends Controller
{
    public function __construct(private CommitteeRepository $committeeRepository, private AgendaRepository $agendaRepository)
    {
    }

    public function index()
    {
        return view('admin.committee.index', [
            'committees' => $this->committeeRepository->get(),
        ]);
    }


    public function create()
    {
        return view('admin.committee.create', [
            'priority_number' => $this->committeeRepository->getNextPriorityNumber(),
            'agendas' => $this->agendaRepository->get(),
        ]);
    }


    public function store(StoreCommitteeRequest $request)
    {
        Pipeline::send($request)
            ->through([
                UploadFile::class,
                CreateCommittee::class,
                ExtractFileText::class,
            ])->then(fn ($data) => $data);

        return back()->with('success', 'Successfully created a committee.');
    }


    public function edit(Committee $committee)
    {
        return view('admin.committee.edit', [
            'committee' => $committee,
            'agendas' => $this->agendaRepository->get(),
        ]);
    }


    public function update(UpdateCommitteeRequest $request, Committee $committee)
    {
        Pipeline::send($request->merge(['committee' => $committee]))
            ->through([
                UploadFile::class,
                UpdateCommittee::class,
                ExtractFileText::class,
            ])->then(fn ($data) => $data);

        return back()->with('success', 'Committee updated successfully.');
    }
}
