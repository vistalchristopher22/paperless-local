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
        $expanded = $payload['expanded_committee'][0] ?? null;
        $others = $payload['expanded_committee'][1] ?? null;
        $this->committeeRepository->update($payload['committee'], [
            'name' => $payload['name'],
            'lead_committee' => $payload['lead_committee'],
            'expanded_committee' => $expanded,
            'expanded_committee_2' => $others,
            'file_path' => $payload['file_path'] ?? $payload['committee']->file_path,
            'status' => (auth()->user()?->account_type === UserTypes::ADMIN->value) ? CommitteeStatus::APPROVED->value : $payload['committee']['status'],
        ]);

        return $next($payload['committee']);
    }
}
