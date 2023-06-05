<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\DivisionRepository;
use Illuminate\Http\Request;


final class DivisionController extends Controller
{
    public function __construct(private DivisionRepository $divisionRepository) {
    }

    public function index()
    {
        return view('user.division.index', [
            'division' => $this->divisionRepository->get()
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
