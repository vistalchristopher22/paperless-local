<?php

namespace App\Pipes\Committee;

use App\Contracts\Pipes\IPipeHandler;
use App\Enums\CommitteeStatus;
use App\Enums\UserTypes;
use App\Repositories\CommitteeRepository;
use Closure;

final class UpdateCommittee implements IPipeHandler
{
    private CommitteeRepository $committeeRepository;

    public function __construct()
    {
        $this->committeeRepository = app()->make(CommitteeRepository::class);
    }

    public function handle(mixed $payload, Closure $next)
    {
        list($expanded_committee, $other_expanded_committee) = $payload['expanded_committee'];
        $this->committeeRepository->update($payload['committee'], [
            'name' => $payload['name'],
            'lead_committee' => $payload['lead_committee'],
            'expanded_committee' => $expanded_committee,
            'expanded_committee_2' => $other_expanded_committee,
            'file_path' => $payload['file_path'] ?? $payload['committee']->file_path,
            'status' => (auth()->user()?->account_type === UserTypes::ADMIN->value) ? CommitteeStatus::APPROVED->value : $payload['status'],
        ]);

        return $next($payload['committee']);
    }
}
