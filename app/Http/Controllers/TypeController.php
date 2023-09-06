<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeEditRequest;
use App\Http\Requests\TypeStoreRequest;
use App\Models\Type;
use App\Repositories\TypeRepository;
use Yajra\DataTables\Facades\DataTables;

final class TypeController extends Controller
{
    public function __construct(private readonly TypeRepository $typeRepository)
    {

    }

    public function list()
    {
        return DataTables::of($this->typeRepository->get())
            ->addColumn('action', function ($record) {
                $btnEdit = "<button class='btn btn-success text-white btn-edit-type'  data-content=" . json_encode($record) . "
                                       title='Edit Type' data-bs-toggle='tooltip' data-bs-placement='top'>
                                        <i class='mdi mdi-pencil-outline'></i>
                                    </button>";

                $btnDelete = "<button class='btn btn-danger text-white btn-delete-type' id='btnSubmit' title='Delete Division' data-id=" . $record->id . "
                                            data-bs-toggle='tooltip' data-bs-placement='top'><i
                                            class='mdi mdi-trash-can-outline'></i></button>";

                return $btnEdit . '&nbsp' . $btnDelete;
            })->make(true);
    }


    public function index()
    {
        return view('admin.types.index');
    }


    public function store(TypeStoreRequest $request)
    {
        $this->typeRepository->store($request->all());
        return response()->json(['success' => true]);
    }


    public function update(TypeEditRequest $request, Type $type)
    {
        $this->typeRepository->update($type, $request->all());
        return response()->json(['success' => true]);
    }


    public function destroy(Type $type)
    {
        return response()->json(['success' => $this->typeRepository->delete($type)]);
    }
}
