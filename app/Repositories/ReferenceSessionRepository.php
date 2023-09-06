<?php

namespace App\Repositories;

use App\Models\ReferenceSession;
use Carbon\Carbon;
use Illuminate\Support\Collection;

final class ReferenceSessionRepository extends BaseRepository
{
    public function __construct(ReferenceSession $model)
    {
        parent::__construct($model);
    }

    public function get(): Collection
    {
        return $this->model->get();
    }

    public function store(array $data = []): ReferenceSession
    {
        return ReferenceSession::firstOrCreate([
            'number' => $data['reference_session'],
            'year' => Carbon::parse($data['selected_date'])->format('Y'),
        ], [
            'number' => $data['reference_session'],
            'year' => Carbon::parse($data['selected_date'])->format('Y'),
        ]);
    }
}
