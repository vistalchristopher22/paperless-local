<?php

namespace App\Http\Controllers\Admin;

use App\Models\Committee;
use App\Http\Controllers\Controller;

class CommitteeFileController extends Controller
{
    public function edit(Committee $committee_file)
    {
        return $committee_file;
    }
}
