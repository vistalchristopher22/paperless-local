<?php

namespace App\Repositories;

use App\Models\ReferenceSession;
use Carbon\Carbon;

final class ReferenceSessionRepository extends BaseRepository
{
    public function __construct(ReferenceSession $model)
    {
        parent::__construct($model);
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
