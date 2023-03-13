<?php

namespace App\Http\Middleware;

use App\Services\AgendaMemberService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConvertIdsToModelsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $members = AgendaMemberService::convertIdsToModel($request->input('members'));
        $request->merge(['members' => $members]);

        return $next($request);
    }
}
