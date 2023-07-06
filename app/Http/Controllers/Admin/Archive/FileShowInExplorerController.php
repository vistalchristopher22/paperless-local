<?php

namespace App\Http\Controllers\Admin\Archive;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

final class FileShowInExplorerController extends Controller
{
    public function __invoke(Request $request)
    {
        $path = $request->directory . DIRECTORY_SEPARATOR . $request->name;
        $basePath = base_path();
        $escaped_path = escapeshellarg($path);
        shell_exec("python.exe $basePath\\explorer.py $escaped_path");
        return response()->json(['success' => true]);
    }
}
