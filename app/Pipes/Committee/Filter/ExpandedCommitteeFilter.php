<?php

namespace App\Pipes\Committee\Filter;

use App\Contracts\Pipes\IPipeHandler;
use Closure;

final class ExpandedCommitteeFilter implements IPipeHandler
{
    public function __construct()
    {
    }

    public function handle(mixed $payload, Closure $next)
    {
        if (request()->expanded && request()->expanded != '*') {
            $payload->where('expanded_committee', request()->expanded);
        }

        return $next($payload);
    }
}
