<?php

namespace App\Pipes\BoardSession;

use App\Contracts\Pipes\IPipeHandler;
use App\Repositories\BoardSessionRespository;
use Closure;

final class DeleteBoardSession implements IPipeHandler
{
    private BoardSessionRespository $repository;

    public function __construct()
    {
        $this->repository = app(BoardSessionRespository::class);
    }

    public function handle(mixed $payload, Closure $next)
    {
        $this->repository->delete($payload);

        return $next($payload);
    }
}
