<?php

namespace App\Pipes\Legislation;

use App\Enums\LegislateType;
use App\Models\Ordinance;
use App\Models\Resolution;
use Closure;
use App\Contracts\Pipes\IPipeHandler;
use Illuminate\Support\Str;

final class UpdateClassificationType implements IPipeHandler
{
    public function handle(mixed $payload, Closure $next)
    {

        if (Str::lower($payload['classification']) !== Str::lower(class_basename($payload['legislation']->legislable_type))) {
            if (Str::lower($payload['classification']) === Str::lower(LegislateType::ORDINANCE->value)) {
                $ordinance = new Ordinance([
                    'file' => $payload['legislation']->legislable->file,
                    'author' => $payload['legislation']->legislable->author,
                    'type' => $payload['legislation']->legislable->type,
                    'session_date' => $payload['legislation']->legislable->session_date,
                ]);
                $payload['new_legislate'] = $ordinance;

            } else {
                $resolution = new Resolution([
                    'file' => $payload['legislation']->legislable->file,
                    'author' => $payload['legislation']->legislable->author,
                    'type' => $payload['legislation']->legislable->type,
                    'session_date' => $payload['legislation']->legislable->session_date,
                ]);

                $payload['new_legislate'] = $resolution;
            }
        }
        return $next($payload);
    }
}
