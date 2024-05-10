<?php

namespace App\Models;

use App\Enums\DisplayScheduleType;
use App\Enums\ScreenDisplayStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScreenDisplay extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'type' => DisplayScheduleType::class,
        'status' => ScreenDisplayStatus::class,
    ];

    public function reference_session()
    {
        return $this->belongsTo(ReferenceSession::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function screen_displayable()
    {
        return $this->morphTo();
    }
}
