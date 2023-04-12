<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Response;

class VerifyUser
{
    public function __construct(private UserService $userService)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($this->userService->verify(request()->password, auth()->user())) {
            return $next($request);
        } else {
            return response()->json(['message' => 'Invalid Password', 'success' => false]);
        }

    }
}
