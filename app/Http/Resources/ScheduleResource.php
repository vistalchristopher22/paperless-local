<?php

/** @noinspection PhpUnused */

namespace App\Http\Resources;

use App\Enums\ScheduleType;
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
            'id' => $this->id,
            'title' => $this->name,
            'start' => $this->date_and_time->format('Y-m-d H:i:s'),
            'end' => $this->date_and_time->format('Y-m-d H:i:s'),
            'with_invited_guest' => $this->with_invited_guest,
            'type' => $this->type,
            'borderColor' => (($this->type == ScheduleType::SESSION->value) ? 'green' : 'blue'),
            'textColor' => 'black',
        ];
    }
}
