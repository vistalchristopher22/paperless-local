<?php

namespace App\Http\Controllers\User;

use App\Models\SanggunianMember;
use App\Http\Controllers\Controller;
use App\Repositories\AgendaRepository;
use App\Repositories\SanggunianMemberRepository;

final class SanggunianMemberController extends Controller
{
    public function index(SanggunianMemberRepository $sanggunianMemberRepository)
    {
        return view('user.sanggunian-member.index', [
            'members' => $sanggunianMemberRepository->get(),
        ]);
    }

    public function show(AgendaRepository $agendaRepository, SanggunianMember $member)
    {
        return $agendaRepository->getAgendasByMember($member);
    }
}
