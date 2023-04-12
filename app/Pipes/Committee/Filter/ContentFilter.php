<?php

namespace App\Pipes\Committee\Filter;

use Closure;
use Illuminate\Support\Facades\DB;
use App\Contracts\Pipes\IPipeHandler;
use App\Models\Committee;

final class ContentFilter implements IPipeHandler
{
    public function __construct()
    {
    }

    public function handle(mixed $payload, Closure $next)
    {
        if (!is_null(request()->content)) {
            $payload = Committee::search(request()->content);
        } else {
            $payload->select(DB::raw('id, name, priority_number, session_schedule, lead_committee, expanded_committee, created_at'));
        }

        return $next($payload->get());
    }
}
