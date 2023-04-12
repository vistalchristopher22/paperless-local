<?php

namespace App\Repositories;

use App\Contracts\IAgendaMember;
use App\Models\Agenda;
use App\Models\AgendaMember;
use App\Models\SanggunianMember;
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

    public function getAgendaOfMember(SanggunianMember $member): Collection
    {
        return $this->model->with(['agenda:id,title'])->where('member', $member->id)->get();
    }

    public function addMembersToThis(Agenda $agenda, Collection|array $members = []): mixed
    {
        return $agenda->members()->saveMany($members);
    }

    public function getMembers(Agenda $agenda): Agenda
    {
        return $agenda->load(['chairman_information', 'vice_chairman_information', 'members', 'members.sanggunian_member']);
    }
}
