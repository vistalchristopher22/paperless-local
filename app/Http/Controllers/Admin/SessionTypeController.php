<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

final class SessionTypeController extends Controller
{
    public function index()
    {
        return inertia('SessionTypeIndex', [
        ]);
    }
}
