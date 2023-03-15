<?php

namespace App\Services;

use App\Models\AgendaMember;
use Illuminate\Support\Collection;

final class AgendaMemberService
{
    public static function convertIdsToModel(array|null $memberIds = []): Collection
    {
        return collect($memberIds)->map(
            fn ($id) =>
            new AgendaMember(['member' => (int) $id])
        );
    }
}
