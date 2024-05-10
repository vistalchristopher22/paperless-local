<?php

namespace App\Models;

use App\Enums\ScheduleType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReferenceSession extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    // public function scheduleCommittees(): HasMany
    // {
    //     return $this->hasMany(Schedule::class)->where('type', ScheduleType::MEETING->value);
    // }

    // public function scheduleSessions(): HasMany
    // {
    //     return $this->hasMany(Schedule::class)->where('type', ScheduleType::SESSION->value);
    // }

    public function reference_session_screen_display()
    {
        return $this->hasMany(ScreenDisplay::class, 'reference_session_id', 'id');
    }
}
