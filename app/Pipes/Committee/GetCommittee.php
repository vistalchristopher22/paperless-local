<?php

namespace App\Pipes\Committee;

use App\Contracts\Pipes\IPipeHandler;
use App\Repositories\CommitteeRepository;
use Closure;

final class GetCommittee implements IPipeHandler
{
    private CommitteeRepository $commiteRepository;

    public function __construct()
    {
        $this->commiteRepository = app()->make(CommitteeRepository::class);
    }

    public function handle(mixed $payload, Closure $next)
    {
        $data = $this->commiteRepository->get(['*']);

        return $next($data);
    }
}
