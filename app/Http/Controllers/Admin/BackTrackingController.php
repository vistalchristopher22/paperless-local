<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

final class BackTrackingController extends Controller
{
    public function index()
    {
        return view('admin.backtracking.index');
    }
}
