<?php

namespace App\Pipes\Committee\Filter;

use Closure;
use App\Contracts\Pipes\IPipeHandler;

final class LeadCommitteeFilter implements IPipeHandler
{
    public function __construct()
    {
    }


    public function handle(mixed $payload, Closure $next)
    {
        if (request()->lead && request()->lead != '*') {
            $payload->where('lead_committee', request()->lead);
        }

        return $next($payload);
    }
}
