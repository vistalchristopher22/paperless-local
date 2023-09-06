<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScreenDisplay extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
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
