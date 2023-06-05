<?php

namespace App\Pipes\Committee;

use Closure;
use Carbon\Carbon;
use App\Contracts\Pipes\IPipeHandler;
use App\Repositories\CommitteeRepository;

final class CreateCommittee implements IPipeHandler
{
    private CommitteeRepository $committeeRepository;

    public function __construct()
    {
        $this->committeeRepository = app()->make(CommitteeRepository::class);
    }

    public function handle(mixed $payload, Closure $next)
    {
        $committee = $this->committeeRepository->store([
            'priority_number'    => $payload['priority_number'],
            'name'               => $payload['name'],
            'lead_committee'     => $payload['lead_committee'],
            'expanded_committee' => $payload['expanded_committee'],
            'file_path'          => $payload['file_path'],
            // 'session_schedule'   => Carbon::parse($payload['schedule']),
            'date'               => now(),
            // 'invited_guests' => array_key_exists('with_guests', $payload),
        ]);

        return $next($committee);
    }
}
