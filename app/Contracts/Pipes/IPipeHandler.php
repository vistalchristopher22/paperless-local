<?php

namespace App\Contracts\Pipes;

use App\Http\Requests\SanggunianMemberStoreRequest;
use Closure;

interface IPipeHandler
{
    public function __construct();
    public function handle(mixed $payload, Closure $next);
}
