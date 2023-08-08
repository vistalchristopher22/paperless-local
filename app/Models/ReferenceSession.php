<?php

namespace App\Models;

use App\Enums\ScheduleType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferenceSession extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function scheduleCommittees(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Schedule::class)->where('type', ScheduleType::MEETING->value);
    }

    public function scheduleSessions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Schedule::class)->where('type', ScheduleType::SESSION->value);
    }
}
