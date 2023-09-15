<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

final class BacktrackingViewFileController extends Controller
{
    public function __invoke(Request $request)
    {
        $basePath = base_path();
        $escaped_path = escapeshellarg($request->path);
        shell_exec("python.exe $basePath\\explorer.py $escaped_path");
    }
}
