<?php

namespace App\Repositories;

use App\Contracts\IAgendaMember;
use App\Models\Agenda;
use App\Models\AgendaMember;
use Illuminate\Support\Collection;

final class AgendaMemberRepository extends BaseRepository implements IAgendaMember
{
    public function __construct(AgendaMember $model)
    {
        parent::__construct($model);
    }

    public function removeExistingMembers(Agenda $agenda): mixed
    {
        $agenda->members()->delete();
        return $this;
    }

    public function addMembersToThis(Agenda $agenda, Collection|array $members = []): mixed
    {
        return $agenda->members()->saveMany($members);
    }
}
