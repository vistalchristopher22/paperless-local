<?php

namespace App\Pipes\Committee;

use App\Contracts\Pipes\IPipeHandler;
use Closure;
use Illuminate\Support\Facades\Http;

final class MongoStoreInCollection implements IPipeHandler
{
    public function __construct()
    {
    }

    public function handle(mixed $payload, Closure $next)
    {
        $response = Http::post(config('app.node_url').'/committees', $payload);

        if ($response->ok()) {
            $committee = $response->json();
        } else {
            $error = $response->json('error');
        }

        return $next($payload);
    }
}
