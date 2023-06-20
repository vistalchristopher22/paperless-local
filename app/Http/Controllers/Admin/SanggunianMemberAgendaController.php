<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SanggunianMember;
use App\Repositories\AgendaRepository;

final class SanggunianMemberAgendaController extends Controller
{
    public function __invoke(AgendaRepository $agendaRepository, SanggunianMember $member)
    {
        return $agendaRepository->getAgendasByMember($member);
    }
}
