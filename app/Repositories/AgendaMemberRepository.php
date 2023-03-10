<?php

namespace App\Repositories;

use App\Models\Agenda;
use App\Models\AgendaMember;
use App\Contracts\IAgendaMember;
use Illuminate\Support\Collection;
use App\Repositories\BaseRepository;
use App\Repositories\AgendaRepository;

final class AgendaMemberRepository extends BaseRepository implements IAgendaMember
{
    public function __construct(AgendaMember $model)
    {
        parent::__construct($model);
    }

    public function addMembersToThis(Agenda $agenda, Collection|array $members = []): mixed
    {
        return $agenda->members()->saveMany($members);
    }
}