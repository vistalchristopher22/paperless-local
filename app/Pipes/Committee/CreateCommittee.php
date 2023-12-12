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
        $expanded = null;
        $others = null;

        $eCommittee = json_decode($payload['expanded_committee'], true);

        if (isset($payload['expanded_committee'])) {

            if (count($eCommittee) >= 2) {
                $expanded = $eCommittee[0] ?? null;
                $others = $eCommittee[1] ?? null;
            } else {
                $expanded = $eCommittee[0] ?? null;
            }
        } else {
            $expanded = null;
            $others = null;
        }


        $committee = $this->committeeRepository->store([
            'name' => $payload['name'],
            'lead_committee' => $payload['lead_committee'],
            'expanded_committee' => $expanded,
            'expanded_committee_2' => $others,
            'file_path' => $payload['file_path'] ?? null,
            'submitted_by' => $payload['submitted_by'],
            'status' => (auth()->user()?->account_type === UserTypes::ADMIN->value) ? CommitteeStatus::APPROVED->value : CommitteeStatus::REVIEW->value,
        ]);

        return $next($committee);
    }
}
