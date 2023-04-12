<?php

namespace App\Pipes\Committee;

use Closure;
use App\Contracts\Pipes\IPipeHandler;
use Illuminate\Support\Facades\Redis;
use App\Repositories\CommitteeRepository;

final class CacheCommittee implements IPipeHandler
{
    private CommitteeRepository $committeeRepository;

    public function __construct()
    {
        $this->committeeRepository = app()->make(CommitteeRepository::class);
    }


    public function handle(mixed $payload, Closure $next)
    {
        Redis::set("committees:" . $payload->id, $this->committeeRepository->findBy('id', $payload->id));
        return $next($payload);
    }
}
