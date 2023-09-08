<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

final class BackTrackingController extends Controller
{
    public function index()
    {
        return view('admin.backtracking.index');
    }
}
