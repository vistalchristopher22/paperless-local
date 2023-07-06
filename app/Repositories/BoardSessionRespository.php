<?php

namespace App\Repositories;

use App\Enums\BoardSessionStatus;
use App\Models\BoardSession;

final class BoardSessionRespository extends BaseRepository
{
    public function __construct(BoardSession $model)
    {
        parent::__construct($model);
    }

    public function createUnassignedBusiness(array $data = []): BoardSession
    {
        return $this->model->create([
            'unassigned_title' => $data['unassigned_title'],
            'unassigned_business' => $data['unassigned_business'],
        ]);
    }

    public function createAnnouncement(array $data = []): BoardSession
    {
        return $this->model->create([
            'announcement_title' => $data['announcement_title'],
            'announcement_content' => $data['announcement_content'],
        ]);
    }

    public function locked(BoardSession $boardSession): BoardSession
    {
        $boardSession->update([
            'status' => BoardSessionStatus::LOCKED,
        ]);

        return $boardSession;
    }

    public function unlocked(BoardSession $boardSession): BoardSession
    {
        $boardSession->update([
            'status' => BoardSessionStatus::UNLOCKED,
        ]);

        return $boardSession;
    }
}
