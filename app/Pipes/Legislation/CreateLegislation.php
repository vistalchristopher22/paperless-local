<?php

namespace App\Pipes\Legislation;

use App\Enums\LegislateType;
use App\Models\Legislation;
use App\Repositories\LegislationRepository;
use Closure;
use App\Contracts\Pipes\IPipeHandler;

final class CreateLegislation implements IPipeHandler
{
    public function __construct()
    {
        $this->legislationRepository = app()->make(LegislationRepository::class);
    }


    public function handle(mixed $payload, Closure $next)
    {
        $legislation = new Legislation([
            'no' => $this->legislationRepository->generateUniqueNumber(LegislateType::from($payload['classification'])),
            'title' => $payload['title'],
            'description' => $payload['description'],
            'classification' => LegislateType::from($payload['classification']),
        ]);

        $legislation->legislable()->associate($payload['associate_data']);
        $legislation->save();

        $payload['legislation'] = $legislation;

        return $next($payload);
    }
}
