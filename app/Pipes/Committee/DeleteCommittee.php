<?php

namespace App\Pipes\Committee;

use Closure;
use App\Contracts\Pipes\IPipeHandler;
use App\Repositories\CommitteeRepository;

final class DeleteCommittee implements IPipeHandler
{
    private CommitteeRepository $committeeRepository;
    
    public function __construct()
    {
        $this->committeeRepository = app()->make(CommitteeRepository::class);
    }

    
    public function handle(mixed $payload, Closure $next)
    {
        $this->committeeRepository->delete($payload);
        return $next($payload);
    }
}
