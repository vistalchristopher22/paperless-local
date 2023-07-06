<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Repositories\AgendaMemberRepository;

final class AgendaMemberController extends Controller
{
    public function members(Agenda $agenda, AgendaMemberRepository $agendaMemberRepository)
    {
        return response()->json(['agenda' => $agendaMemberRepository->getMembers($agenda)]);
    }
}
