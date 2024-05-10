<?php

namespace App\Contracts;

use App\Models\Schedule;
use App\Models\ReferenceSession;

interface ScreenDisplayRepositoryInterface
{
    public function updateScreenDisplays(Schedule $data);

    public function getCurrentScreenDisplay(Schedule $data);

    public function getUpNextScreenDisplay(ReferenceSession $data);

    public function getByReferenceSession(int $id);

    public function getSortedByReferenceSession(int $id);

    public function reOrderDisplay(array $data = []): bool;
}
