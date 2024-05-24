<?php

namespace App\Pipes\SanggunianMember;

use App\Contracts\Pipes\IPipeHandler;
use App\Repositories\SanggunianMemberRepository;

// use App\Models\SanggunianMember;
use Closure;

final class UpdateSanggunianMember implements IPipeHandler
{
    private SanggunianMemberRepository $sangguninanMemberRepository;

    public function __construct()
    {
        $this->sangguninanMemberRepository = app()->make(SanggunianMemberRepository::class);
    }

    public function handle(mixed $payload, Closure $next)
    {
        $this->sangguninanMemberRepository->update($payload['sanggunianMember'], [
            'fullname'        => 'Hon. ' . $payload['fullname'],
            'district'        => $payload['district'],
            'sanggunian'      => $payload['sanggunian'],
            'official_title'  => $payload['official_title'],
            'profile_picture' => $payload['profile_picture'] ?? $payload['sanggunianMember']['profile_picture'],
        ]);

        // dd($data);

        return $next($payload);
    }
}
