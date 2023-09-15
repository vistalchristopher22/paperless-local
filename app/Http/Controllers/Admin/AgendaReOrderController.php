<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\AgendaRepository;

final class AgendaReOrderController extends Controller
{
    public function __invoke(AgendaRepository $agendaRepository, Request $request)
    {
        $result = $agendaRepository->reOrderIndex($request->all());
        return response()->json(['success' => $result]);
    }
}
