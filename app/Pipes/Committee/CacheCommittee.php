<?php

namespace App\Pipes\Committee;

use App\Contracts\Pipes\IPipeHandler;
use App\Repositories\CommitteeRepository;
use Closure;
use Illuminate\Support\Facades\Redis;

final class CacheCommittee implements IPipeHandler
{
    private CommitteeRepository $committeeRepository;

    public function __construct()
    {
        $this->committeeRepository = app()->make(CommitteeRepository::class);
    }

    public function handle(mixed $payload, Closure $next)
    {
        Redis::set('committees:' . $payload->id, $this->committeeRepository->findBy('id', $payload->id));

        return $next($payload);
    }
}
