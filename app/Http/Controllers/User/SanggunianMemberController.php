<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\SanggunianMemberRepository;

final class SanggunianMemberController extends Controller
{
    public function __invoke(SanggunianMemberRepository $sanggunianMemberRepository)
    {
        return view('user.sanggunian-member.index', [
            'members' => $sanggunianMemberRepository->get(),
        ]);
    }
}
