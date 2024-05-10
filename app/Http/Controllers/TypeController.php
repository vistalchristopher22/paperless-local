<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeEditRequest;
use App\Http\Requests\TypeStoreRequest;
use App\Models\Type;
use App\Repositories\TypeRepository;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;

final class TypeController extends Controller
{
    public function __construct(private readonly TypeRepository $typeRepository)
    {

    }


    public function index(): Response
    {
        return Inertia::render('TypeIndex', [
            'types' => $this->typeRepository->paginate()]);
    }



    public function store(TypeStoreRequest $request): JsonResponse
    {
        $this->typeRepository->store([
            'name' => $request->name ?? null,
        ]);
        return response()->json(['success' => true]);
    }


    public function update(TypeEditRequest $request, Type $type): JsonResponse
    {
        $this->typeRepository->update($type, [
            'name' => $request->name ?? null,
        ]);
        return response()->json(['success' => true]);
    }


    public function destroy(Type $type): JsonResponse
    {
        return response()->json(['success' => $this->typeRepository->delete($type)]);
    }
}
