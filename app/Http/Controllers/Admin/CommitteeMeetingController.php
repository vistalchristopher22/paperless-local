<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

final class CommitteeMeetingController extends Controller
{
    public function index()
    {
        return view('admin.committee-meeting.index');
    }
}
