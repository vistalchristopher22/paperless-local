<?php

/** @noinspection PhpUnused */

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $date_and_time
 * @property mixed $date_and_time
 * @property mixed $with_invited_guest
 * @property mixed $type
 * @property mixed $type
 */
class ScheduleResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'title'            => str()->upper($this->reference_session) . ' - ' . str()->upper($this->type),
            'committees_count' => (int) $this->committees_count,
            'start'            => $this->date_and_time->format('Y-m-d'),
            'end'              => $this->date_and_time->format('Y-m-d'),
            'type'             => $this->type,
            'backgroundColor'  => '#0b51b7',
            'textColor'        => 'white',
        ];
    }
}
