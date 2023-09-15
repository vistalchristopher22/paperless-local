<?php

namespace App\Contracts;

use App\Models\ReferenceSession;

interface ScreenDisplayRepositoryInterface
{
    public function updateScreenDisplays(ReferenceSession $data);

    public function getCurrentScreenDisplay(ReferenceSession $data);

    public function getUpNextScreenDisplay(ReferenceSession $data);

    public function getByReferenceSession(int $id);

    public function getSortedByReferenceSession(int $id);

    public function reOrderDisplay(array $data = []): bool;
}
