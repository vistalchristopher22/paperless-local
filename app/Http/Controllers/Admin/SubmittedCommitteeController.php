<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Committee;
use App\Transformers\SubmittedLaraTables;
use Freshbitsweb\Laratables\Laratables;

final class SubmittedCommitteeController extends Controller
{
    public function __invoke()
    {
        return Laratables::recordsOf(Committee::class, SubmittedLaraTables::class);
    }
}
