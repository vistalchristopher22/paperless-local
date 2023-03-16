<?php

namespace App\Pipes\Committee;

use App\Contracts\Pipes\IPipeHandler;
use App\Repositories\CommitteeRepository;
use Closure;

final class CreateCommittee implements IPipeHandler
{
    private CommitteeRepository $committeeRepository;

    public function __construct()
    {
        $this->committeeRepository = app()->make(CommitteeRepository::class);
    }

    public function handle(mixed $data, Closure $next)
    {
        $committee = $this->committeeRepository->store([
            'priority_number'    => $data['priority_number'],
            'name'               => $data['name'],
            'lead_committee'     => $data['lead_committee'],
            'expanded_committee' => $data['expanded_committee'],
            'file_path'          => $data['file_path'],
            'session_schedule'   => $data['schedule'],
            'date'               => now(),
        ]);

        return $next($committee);
    }
}
