<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

final class ScheduleController extends Controller
{
    public function index()
    {
        return view('admin.schedules.index');
    }
}
