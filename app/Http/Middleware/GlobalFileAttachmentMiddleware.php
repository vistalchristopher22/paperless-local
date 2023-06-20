<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

// ...

class GlobalFileAttachmentMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $url = url()->current();

        // List of allowed extensions
        $allowedExtensions = ['pdf', 'xls', 'xlsx', 'doc', 'docx', 'webp'];

        // Extract the file extension from the URL
        $extension = pathinfo($url, PATHINFO_EXTENSION);

        if (in_array($extension, $allowedExtensions)) {
            $fileName = basename($url);

            $fileName = str_replace($extension, Str::reverse($extension), $fileName);
            $url = str_replace(basename($url), $fileName, $url);
            $location = str_replace(url('/'), "", $url);
            $location = str_replace("/", "..", $location);
            return redirect()->route('show-attachment', [$fileName, $location]);
        }
        return $next($request);
    }
}
