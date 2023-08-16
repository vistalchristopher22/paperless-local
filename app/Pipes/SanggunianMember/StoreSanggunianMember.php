<?php

namespace App\Pipes\SanggunianMember;

use App\Contracts\Pipes\IPipeHandler;
use App\Repositories\SanggunianMemberRepository;
use Closure;

final class StoreSanggunianMember implements IPipeHandler
{
    private SanggunianMemberRepository $sanggunianMemberRepository;

    public function __construct()
    {
        $this->sanggunianMemberRepository = app()->make(SanggunianMemberRepository::class);
    }

    public function handle(mixed $payload, Closure $next)
    {
        $this->sanggunianMemberRepository->store([
            'fullname' => $payload['fullname'],
            'district' => $payload['district'],
            'sanggunian' => $payload['sanggunian'],
            'profile_picture' => $payload['profile_picture'] ?? 'no_image.png',
        ]);

        return $next($payload);
    }
}
