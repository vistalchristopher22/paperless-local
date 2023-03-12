<?php

namespace App\Repositories;

use App\Models\Agenda;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
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
     * @return Collection The model with the relationships.
     */
    public function get(): Collection
    {
        return $this->model->with(['chairman_information', 'vice_chairman_information', 'members', 'members.sanggunian_member'])->get();
    }

    /**
     * It stores an agenda and its members in the database.
     * {@inheritdoc}
     * @param array data an array of data that will be used to create the agenda
     */
    public function store(array $data = []): mixed
    {
        return DB::transaction(function () use ($data) {

            $newlyStoredAgenda = parent::store([
                'title' => $data['title'],
                'description' => $data['description'],
                'chairman' => $data['chairman'],
                'vice_chairman' => $data['vice_chairman'],
            ]);

            return $this->agendaMemberRepository->addMembersToThis(agenda: $newlyStoredAgenda, members: $data['members']);
        });
    }
}
