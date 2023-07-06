<?php

namespace App\Http\Controllers\Admin;

use App\Models\Committee;
use App\Http\Controllers\Controller;
use Freshbitsweb\Laratables\Laratables;
use App\Transformers\SubmittedLaraTables;

final class SubmittedCommitteeController extends Controller
{
    public function __invoke()
    {
        return Laratables::recordsOf(Committee::class, SubmittedLaraTables::class);
    }
}
