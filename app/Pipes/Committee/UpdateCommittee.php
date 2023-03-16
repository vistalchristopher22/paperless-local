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

    public function handle(mixed $data, Closure $next)
    {
        $this->committeeRepository->update($data['committee'], [
            'priority_number'    => $data['priority_number'],
            'name'               => $data['name'],
            'lead_committee'     => $data['lead_committee'],
            'expanded_committee' => $data['expanded_committee'],
            'file_path'          => $data['file_path'] ?? $data['committee']->file_path,
            'session_schedule'   => $data['schedule'],
            'date'               => now(),
        ]);

        return $next($data['committee']);
    }
}
