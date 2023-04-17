<?php

namespace App\Pipes\BoardSession;

use Closure;
use App\Contracts\Pipes\IPipeHandler;

final class UpdateBoardSession implements IPipeHandler
{
    public function __construct()
    {
    }


    public function handle(mixed $payload, Closure $next)
    {
        $boardSession = $payload['boardSession'];
        $boardSession->title = $payload['title'];
        $boardSession->unassigned_title = $payload['unassigned_title'];
        $boardSession->unassigned_business = $payload['unassigned_business'];
        $boardSession->announcement_title = $payload['announcement_title'];
        $boardSession->announcement_content = $payload['announcement_content'];
        $boardSession->save();
        return $next($payload);
    }
}
