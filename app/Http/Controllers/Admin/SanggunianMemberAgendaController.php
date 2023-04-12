<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SanggunianMember;
use App\Repositories\AgendaRepository;

final class SanggunianMemberAgendaController extends Controller
{
    public function __construct(private AgendaRepository $agendaRepository)
    {
    }

    public function __invoke(SanggunianMember $member)
    {
        return $this->agendaRepository->getAgendasByMember($member);
    }
}
