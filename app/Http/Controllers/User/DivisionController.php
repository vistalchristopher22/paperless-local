<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\DivisionRepository;

final class DivisionController extends Controller
{
    public function __invoke(DivisionRepository $divisionRepository)
    {
        return view('user.division.index', [
            'division' => $divisionRepository->get(),
        ]);
    }
}
