<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BoardSession extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function schedule_information()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id', 'id');
    }

    public function display(): MorphOne
    {
        return $this->morphOne(ScreenDisplay::class, 'screen_displayable');
    }

    public function file_link()
    {
        return $this->hasOne(BoardSessionCommitteeLink::class);
    }

    public function submitted(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by', 'id');
    }

}
