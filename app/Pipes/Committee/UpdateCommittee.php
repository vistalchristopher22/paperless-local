<?php

namespace App\Pipes\Committee;

use App\Contracts\Pipes\IPipeHandler;
use App\Enums\CommitteeStatus;
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
        $this->committeeRepository->update($payload['committee'], [
            'name' => $payload['name'],
            'lead_committee' => $payload['lead_committee'],
            'expanded_committee' => $payload['expanded_committee'],
            'file_path' => $payload['file_path'] ?? $payload['committee']->file_path,
            'status' => CommitteeStatus::REVIEW->value,
        ]);

        return $next($payload['committee']);
    }
}
