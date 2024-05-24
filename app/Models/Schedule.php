<?php

namespace App\Models;

use App\Enums\DisplayScheduleType;
use App\Enums\ScreenDisplayStatus;
use Illuminate\Database\Eloquent\Model;
use App\Models\LegislativeAttendance\AttendanceLog;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $casts = [
        'date_and_time' => 'datetime',

    ];

    public function screen_displays(): HasMany
    {
        return $this->hasMany(ScreenDisplay::class, 'schedule_id', 'id');
    }

    public function with_guest_committees(): HasMany
    {
        return $this->hasMany(Committee::class, 'schedule_id', 'id')->where('invited_guests', 1)->orderBy('display_index', 'ASC');
    }

    public function without_guest_committees(): HasMany
    {
        return $this->hasMany(Committee::class, 'schedule_id', 'id')->where('invited_guests', 0)->orderBy('display_index', 'ASC');
    }

    public function committees()
    {
        return $this->hasMany(Committee::class, 'schedule_id', 'id');
    }

    public function order_of_business_information()
    {
        return $this->hasOne(BoardSession::class, 'id', 'order_of_business');
    }

    public function board_sessions(): HasMany
    {
        return $this->hasMany(BoardSession::class, 'schedule_id', 'id');
    }

    public function regular_session(): BelongsTo
    {
        return $this->belongsTo(ReferenceSession::class, 'reference_session_id', 'id');
    }

    public function guests(): HasMany
    {
        return $this->hasMany(ScheduleGuest::class, 'schedule_id', 'id');
    }

    public function schedule_venue()
    {
        return $this->hasOne(Venue::class, 'id', 'venue');
    }

    public function attendance_logs(): HasMany
    {
        return $this->hasMany(AttendanceLog::class, 'schedule_id', 'id');
    }

    public function attendance_logs_present(): HasMany
    {
        return $this->attendance_logs()->where('status', 'present');
    }

    public function attendance_logs_absent(): HasMany
    {
        return $this->attendance_logs()->where('status', 'absent');
    }

    public function attendance_logs_on_official_business(): HasMany
    {
        return $this->attendance_logs()->where('status', 'on_official_business');
    }

    public function attendance_logs_late(): HasMany
    {
        return $this->attendance_logs()->where('status', 'late');
    }

    public function attendance_on_sick_leave(): HasMany
    {
        return $this->attendance_logs()->where('status', 'on_sick_leave');
    }
}
