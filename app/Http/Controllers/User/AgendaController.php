<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\AgendaRepository;

final class AgendaController extends Controller
{
    public function __invoke(AgendaRepository $agendaRepository)
    {
        return view('user.agendas.index', [
            'agendas' => $agendaRepository->get()
        ]);
    }
}
