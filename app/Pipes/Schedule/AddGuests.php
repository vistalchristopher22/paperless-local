<?php

namespace App\Pipes\Schedule;

use Closure;
use App\Contracts\Pipes\IPipeHandler;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

final class AddGuests implements IPipeHandler
{
    public function __construct()
    {
    }

    public function handle(mixed $payload, Closure $next)
    {
        if ($payload['guests'] === "on") {
            $payload['invited_guests'] = Arr::whereNotNull($payload['invited_guests']);
            $payload['schedule']->guests()->delete();
            Arr::map($payload['invited_guests'], function ($guest) use ($payload) {
                $payload['schedule']->guests()->create([
                    'schedule_id' => $payload['schedule']->id,
                    'fullname' => Str::upper($guest),
                ]);
            });
        } else {
            $payload['schedule']->guests()->delete();
        }
        return $next($payload['schedule']->id);
    }
}
