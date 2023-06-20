<?php

namespace App\Pipes\Committee;

use Closure;
use App\Enums\CommitteeStatus;
use App\Contracts\Pipes\IPipeHandler;

final class ApprovedSubmittedCommittee implements IPipeHandler
{
    public function __construct()
    {
    }

    public function handle(mixed $payload, Closure $next)
    {
        $payload->status = CommitteeStatus::APPROVED->value;
        $payload->save();
        return $next($payload);
    }
}
