<?php

namespace App\Pipes\BoardSession;

use App\Contracts\Pipes\IPipeHandler;
use Closure;

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
        $boardSession->announcement_title = $payload['announcement_title'];
        $boardSession->announcement_content = $payload['announcement_content'];
        $boardSession->order_business_note = $payload['orderBusinessNote'];
        $boardSession->unassigned_business_note = $payload['unAssignedBusinessNote'];
        $boardSession->save();

        return $next($payload);
    }
}
