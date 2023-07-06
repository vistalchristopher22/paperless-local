<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Utilities\CommitteeFileUtility;

// ...

class GlobalFileAttachmentMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $url = url()->current();
        if (Str::contains($url, 'custom-attachment')) {
            $allowedExtensions = ['pdf', 'xls', 'xlsx', 'doc', 'docx', 'webp', 'txt'];
            $extension = pathinfo($url, PATHINFO_EXTENSION);
            if (in_array($extension, $allowedExtensions)) {
                $fileName = basename($url);
                $location = dirname($url);
                return redirect()->route('show-attachment', [$fileName, CommitteeFileUtility::temporaryReplaceForwardSlash($location)]);
            }
        }

        return $next($request);
    }
}
