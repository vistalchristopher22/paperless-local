<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

final class TypeController extends Controller
{
    public function list()
    {
        $types = DB::table('types')->select('name', 'created_at')->orderBy('created_at', 'desc')->get();

        return DataTables::of($types)
            ->addColumn('action', function () {

                $btnEdit = '<a href="#" class="btn btn-sm btn-info" data-key="editBtn">
                <i class="mdi mdi-pencil-outline"></i>
                </a>';

                $btnDelete = '<a href="#" class="btn btn-sm btn-danger" data-key="deleteBtn">
                <i class="mdi mdi-trash-can-outline"></i>
                </a>';

                return $btnEdit .'&nbsp'. $btnDelete;
            })->make(true);
    }


    public function index()
    {
        return view('admin.types.index');
    }


    public function create()
    {
    }


    public function store(Request $request)
    {
        Type::create([
            'name' => $request->name
        ]);

        return response()->json(['success' => true]);
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
