<?php

namespace App\Pipes\Committee;

use App\Contracts\Pipes\IPipeHandler;
use App\Enums\CommitteeStatus;
use App\Repositories\CommitteeRepository;
use Closure;

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
            'name' => $payload['name'],
            'lead_committee' => $payload['lead_committee'],
            'expanded_committee' => $payload['expanded_committee'],
            'file_path' => $payload['file_path'],
            'submitted_by' => $payload['submitted_by'],
            'status' => CommitteeStatus::REVIEW->value,
        ]);

        return $next($committee);
    }
}
