<?php

namespace App\Contracts;

use App\Models\Agenda;

interface IAgendaMember
{
    public function removeExistingMembers(Agenda $agenda): mixed;
    public function addMembersToThis(int $agendaID, array $members = []): mixed;
    public function getMembers(Agenda $agenda): Agenda;
}
