<?php

namespace App\Pipes\Committee\Filter;

use Closure;
use App\Contracts\Pipes\IPipeHandler;

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
