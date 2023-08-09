<?php

namespace App\Repositories;

use App\Enums\LegislateType;
use App\Models\Legislation;
use Illuminate\Support\Str;

class LegislationRepository extends BaseRepository
{
    public const RESOLUTION_SHORT = 'RES' . '-';
    public const ORDINANCE_SHORT = 'ORD' . '-';

    public function __construct(Legislation $model)
    {
        parent::__construct($model);
    }

    private function getRecordByClassification(LegislateType $classification): ?Legislation
    {
        return $this->model->where('classification', $classification)->latest()->first();
    }

    private function generateNumberForResolution(): string
    {
        $latestNumber = Str::remove(self::RESOLUTION_SHORT, $this->getRecordByClassification(LegislateType::RESOLUTION)?->no);
        return self::RESOLUTION_SHORT . str_pad((int) ++$latestNumber, 4, '0', STR_PAD_LEFT);
    }

    private function generateNumberForOrdinance(): string
    {
        $latestNumber = Str::remove(self::ORDINANCE_SHORT, $this->getRecordByClassification(LegislateType::ORDINANCE)?->no);
        return self::ORDINANCE_SHORT . str_pad((int) ++$latestNumber, 4, '0', STR_PAD_LEFT);
    }

    public function generateUniqueNumber(LegislateType $classification): string
    {
        return match ($classification->value) {
            LegislateType::ORDINANCE->value => $this->generateNumberForOrdinance(),
            default => $this->generateNumberForResolution()
        };
    }
}
