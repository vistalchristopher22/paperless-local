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

    public function __construct(CommitteeRepository $committeeRepository)
    {
        $this->committeeRepository = $committeeRepository;
    }

    public function handle(mixed $payload, Closure $next)
    {
        $eCommittee = json_decode($payload['expanded_committee'], true);
        $expanded   = null;
        $others     = null;

        if (isset($payload['expanded_committee'])) {
            $expanded = $eCommittee[0] ?? null;
            if (count($eCommittee) >= 2) {
                $others = $eCommittee[1] ?? null;
            }
        }

        $committee = $this->committeeRepository->store([
            'name'                 => $payload['name'],
            'lead_committee'       => $payload['lead_committee'],
            'expanded_committee'   => $expanded,
            'expanded_committee_2' => $others,
            'file_path'            => $payload['file_path'] ?? null,
            'submitted_by'         => $payload['submitted_by'],
            'status'               => (auth()->user()?->account_type === UserTypes::ADMIN->value) ? CommitteeStatus::APPROVED->value : CommitteeStatus::REVIEW->value,
        ]);

        $committee = $committee->load('committee_invited_guests');
        $committee->refresh();

        return $next($committee);
    }
}
