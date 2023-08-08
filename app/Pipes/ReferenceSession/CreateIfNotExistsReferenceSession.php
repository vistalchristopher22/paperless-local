<?php

namespace App\Pipes\ReferenceSession;

use App\Repositories\ReferenceSessionRepository;
use Closure;
use App\Contracts\Pipes\IPipeHandler;

final class CreateIfNotExistsReferenceSession implements IPipeHandler
{
    public function __construct(private readonly ReferenceSessionRepository $referenceSessionRepository)
    {
    }


    public function handle(mixed $payload, Closure $next)
    {
        $reference = $this->referenceSessionRepository->store($payload);
        $payload['reference'] = $reference;
        return $next($payload);
    }
}
