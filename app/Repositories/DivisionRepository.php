<?php

namespace App\Repositories;

use App\Models\Division;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class DivisionRepository extends BaseRepository
{
    // Change the modal
    public function __construct(Division $model)
    {
        parent::__construct($model);
    }

    public function get(): Collection
    {
        return $this->model->get();
    }

    public function store(array $data = []): mixed
    {
        return DB::transaction(function () use ($data) {
            $division = parent::store([
                'name' => $data['name'],
                'description' => $data['description'],
            ]);

            return $division;
        });
    }
}
