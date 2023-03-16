<?php

namespace App\Pipes\Committee;

use Closure;
use App\Contracts\Pipes\IPipeHandler;
use App\Repositories\CommitteeRepository;

final class UpdateCommittee implements IPipeHandler
{
    private CommitteeRepository $committeeRepository;

    public function __construct()
    {
        $this->committeeRepository = app()->make(CommitteeRepository::class);
    }

    public function handle(mixed $payload, Closure $next)
    {
        $this->committeeRepository->update($payload['committee'], [
            'priority_number'    => $payload['priority_number'],
            'name'               => $payload['name'],
            'lead_committee'     => $payload['lead_committee'],
            'expanded_committee' => $payload['expanded_committee'],
            'file_path'          => $payload['file_path'] ?? $payload['committee']->file_path,
            'session_schedule'   => $payload['schedule'],
            'date'               => now(),
        ]);

        return $next($payload['committee']);
    }
}
