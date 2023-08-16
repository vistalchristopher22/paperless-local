<?php

namespace App\Pipes\Committee;

use App\Contracts\Pipes\IPipeHandler;
use App\Enums\CommitteeStatus;
use App\Enums\UserTypes;
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
        $expanded = $payload['expanded_committee'][0] ?? null;
        $others = $payload['expanded_committee'][1] ?? null;

        $committee = $this->committeeRepository->store([
            'name' => $payload['name'],
            'lead_committee' => $payload['lead_committee'],
            'expanded_committee' => $expanded,
            'expanded_committee_2' => $others,
            'file_path' => $payload['file_path'],
            'submitted_by' => $payload['submitted_by'],
            'status' => (auth()->user()?->account_type === UserTypes::ADMIN->value) ? CommitteeStatus::APPROVED->value : CommitteeStatus::REVIEW->value,
        ]);

        return $next($committee);
    }
}
