<?php

namespace App\Pipes\BoardSession;

use App\Contracts\Pipes\IPipeHandler;
use Closure;

final class UpdateBoardSession implements IPipeHandler
{
    public function handle(mixed $payload, Closure $next)
    {
        $boardSession = $payload['session'];
        $boardSession->title = $payload['title'];
        $boardSession->submitted_by = auth()->user()->id;
        $boardSession->save();

        return $next($payload);
    }
}
