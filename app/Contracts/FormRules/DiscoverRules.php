<?php

namespace App\Contracts\FormRules;

interface DiscoverRules
{
    public function getBaseRule(): string;

    public function getRules(string $type): array;
}
