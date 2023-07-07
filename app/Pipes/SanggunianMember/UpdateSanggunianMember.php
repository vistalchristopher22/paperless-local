<?php

namespace App\Pipes\SanggunianMember;

use App\Contracts\Pipes\IPipeHandler;
use App\Repositories\SanggunianMemberRepository;
// use App\Models\SanggunianMember;
use Closure;

final class UpdateSanggunianMember implements IPipeHandler
{
    private SanggunianMemberRepository $sangguninanMemberRepository;
    // private SanggunianMember $sanggunianMember;

    public function __construct()
    {
        $this->sangguninanMemberRepository = app()->make(SanggunianMemberRepository::class);
        // $this->sanggunianMember = app()->make(SanggunianMember::class);
    }

    public function handle(mixed $payload, Closure $next)
    {
        $this->sangguninanMemberRepository->update($payload['sanggunianMember'], [
            'fullname' => $payload['fullname'],
            'district' => $payload['district'],
            'sanggunian' => $payload['sanggunian'],
            'profile_picture' => $payload['profile_picture'] ?? $payload['sanggunianMember']['profile_picture'],
        ]);

        // dd($data);

        return $next($payload);
    }
}
