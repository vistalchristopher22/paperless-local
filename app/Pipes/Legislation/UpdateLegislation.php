<?php

namespace App\Pipes\Legislation;

use App\Enums\LegislateType;
use App\Repositories\LegislationRepository;
use Closure;
use App\Contracts\Pipes\IPipeHandler;

final class UpdateLegislation implements IPipeHandler
{
    public function __construct()
    {
        $this->legislationRepository = app()->make(LegislationRepository::class);
    }


    public function handle(mixed $payload, Closure $next)
    {
        if (array_key_exists('new_legislate', $payload) && $payload['new_legislate']) {
            $payload['new_legislate']->save();


            $payload['legislation']->update([
                'no' => $this->legislationRepository->generateUniqueNumber(LegislateType::from($payload['classification'])),
                'reference_no' => $payload['reference_no'],
                'title' => $payload['title'],
                'description' => $payload['description'],
                'classification' => $payload['classification'],
                'legislable_type' => $payload['new_legislate']::class,
                'legislable_id' => $payload['new_legislate']->id,
            ]);

            $payload['legislation']->legislable->delete();
            $payload['legislation']->legislable()->associate($payload['new_legislate']);
        } else {
            $payload['legislation']->update([
                'no' => $payload['legislation']->no,
                'title' => $payload['title'],
                'reference_no' => $payload['reference_no'],
                'description' => $payload['description'],
                'classification' => $payload['classification'],
            ]);
        }

        return $next($payload);
    }
}
