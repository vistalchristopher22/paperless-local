<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\AgendaRepository;
use App\Repositories\UserAccessRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

final class UserAccessController extends Controller
{
    private UserRepository $userRepository;

    private AgendaRepository $agendaRepository;

    private UserAccessRepository $userAccessRepository;

    public function __construct()
    {
        $this->userRepository = app()->make(UserRepository::class);
        $this->agendaRepository = app()->make(AgendaRepository::class);
        $this->userAccessRepository = app()->make(UserAccessRepository::class);
    }

    public function index()
    {
        return view('admin.account.access.index', [
            'users' => $this->userRepository->getAllNormalUsers(),
            'agendas' => $this->agendaRepository->get(),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->userAccessRepository->grantAccess($request->agendas, $this->userRepository->findBy('id', $request->user));

        return response()->json(['success' => true, 'message' => 'Access granted successfully!']);
    }

    public function show(int $id)
    {
        return $this->userAccessRepository->getAllAccessByUser($this->userRepository->findBy('id', $id));
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
