<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
        ];
        // return parent::toArray($request);
    }
}
