<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $casts = [
        'date_and_time' => 'datetime',
    ];

    public function committees(): HasMany
    {
        return $this->hasMany(Committee::class, 'schedule_id', 'id')->orderBy('display_index', 'ASC');
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
}
