<?php

namespace App\Repositories;

use App\Models\Agenda;
use App\Models\SanggunianMember;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

final class AgendaRepository extends BaseRepository
{
    /**
     * The constructor of the AgendaRepository class is called, which in turn calls the constructor of
     * the BaseRepository class, which in turn calls the constructor of the EloquentRepository class
     *
     * @param Agenda model The model that the repository will be working with.
     */
    public function __construct(Agenda $model, private AgendaMemberRepository $agendaMemberRepository)
    {
        parent::__construct($model);
    }

    /**
     * It gets the model, then gets the chairman_information, vice_chairman_information, members, and
     * members.sanggunian_member.
     * {@inheritdoc}
     *
     * @return Collection The model with the relationships.
     */
    public function get(): Collection
    {
        return $this->model->orderBy('index', 'ASC')->with(['chairman_information', 'vice_chairman_information', 'members', 'members.sanggunian_member'])->get();
    }

    /**
     * > It stores an agenda and its members in the database
     * {@inheritdoc}
     * @param array data The data to be stored.
     *
     * @return mixed The newly stored agenda with the members added to it.
     */
    public function store(array $data = []): mixed
    {
        return DB::transaction(function () use ($data) {
            $newlyStoredAgenda = parent::store(Arr::except($data, 'members'));
            return $this->agendaMemberRepository->addMembersToThis(agenda: $newlyStoredAgenda, members: $data['members']);
        });
    }

    /**
     * > We are updating the agenda and removing the existing members and adding the new members to the
     * agenda
     * {@inheritdoc}
     *
     * @param Model agenda The agenda model instance
     * @param array data The data to be used to update the model.
     *
     * @return mixed True
     */
    public function update(Model $agenda, array $data = []): mixed
    {
        DB::transaction(function () use ($agenda, $data) {
            parent::update($agenda, Arr::except($data, 'members'));
            $this->agendaMemberRepository->removeExistingMembers($agenda);
            $this->agendaMemberRepository->addMembersToThis($agenda, $data['members']);
        });
        return true;
    }

    /**
     * It returns an array of the ids of the members of the given agenda
     *
     * @param Agenda agenda The agenda object
     *
     * @return array An array of the members id's
     */
    public function getMembersId(Agenda $agenda): array
    {
        return $agenda->members->pluck('member')->toArray();
    }

    /**
     * Retrieve agendas based on a given SanggunianMember.
     * @param SanggunianMember $member The SanggunianMember object to retrieve agendas for.
     * @return array Returns an array containing the agendas, separated by chairman, vice_chairman, and member.
     */
    public function getAgendasByMember(SanggunianMember $member): array
    {
        $chairmanInAgenda = $this->model->where('chairman', $member->id)->get();
        $viceChairmanInAgenda = $this->model->where('vice_chairman', $member->id)->get();
        $memberInAgenda = $this->agendaMemberRepository->getAgendaOfMember($member);

        return [
            'chairman'      => $chairmanInAgenda,
            'vice_chairman' => $viceChairmanInAgenda,
            'member'        => $memberInAgenda,
        ];
    }

    /**
     * It updates the index of the record with the given id.
     *
     * @param array data The data to be updated.
     *
     * @return bool A boolean value.
     */
    public function reOrderIndex(array $data = []): bool
    {
        return $this->findBy('id', $data['id'])->update([
            'index' => $data['index'],
        ]);
    }
}
