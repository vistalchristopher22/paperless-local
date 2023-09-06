<?php

namespace App\Pipes\Ordinance;

use App\Repositories\OrdinanceRepository;
use Closure;
use App\Contracts\Pipes\IPipeHandler;

final class CreateOrdinance implements IPipeHandler
{
    private readonly OrdinanceRepository $ordinanceRepository;

    public function __construct()
    {
        $this->ordinanceRepository = app()->make(OrdinanceRepository::class);
    }


    public function handle(mixed $payload, Closure $next)
    {
        $payload['associate_data'] = $this->ordinanceRepository->store([
            'file' => $payload['file'],
            'author' => $payload['author'],
            'co_author' => $payload['co_author'],
            'type' => $payload['type'],
            'session_date' => $payload['sessionDate'],
        ]);
        return $next($payload);
    }
}
