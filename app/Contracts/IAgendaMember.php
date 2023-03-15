<?php

namespace App\Contracts;

use App\Models\Agenda;
use Illuminate\Support\Collection;

interface IAgendaMember
{
    public function removeExistingMembers(Agenda $agenda): mixed;
    public function addMembersToThis(Agenda $agenda, Collection|array $members = []): mixed;
}
