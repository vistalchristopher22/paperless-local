<?php

namespace App\Models;

use App\Enums\BoardSessionStatus;
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

    public $casts = [
        'status' => BoardSessionStatus::class,
    ];

    protected $perPage = 8;

    public $appends = ['file'];

    public function schedule_information()
    {
        return $this->belongsTo(Schedule::class, 'id', 'order_of_business');
    }

    public function display(): MorphOne
    {
        return $this->morphOne(ScreenDisplay::class, 'screen_displayable');
    }

    public function file_link()
    {
        return $this->hasOne(BoardSessionCommitteeLink::class)->latestOfMany();
    }

    public function submitted(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by', 'id');
    }

    public function getFileAttribute(): string
    {
        return basename($this->file_path ?? "");
    }
}
