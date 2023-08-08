<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Committee extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'committees';

    protected $guarded = [];

    public $appends = [
        'file_name',
        'file',
        'submitted_at',
    ];

    public $casts = [
        'date' => 'date',
        'session_schedule' => 'date',
    ];

    protected function submittedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($_) => $this->created_at->format('F d, Y h:i A'),
        );
    }

    public function lead_committee_information(): HasOne
    {
        return $this->hasOne(Agenda::class, 'id', 'lead_committee');
    }

    public function schedule_information(): BelongsTo
    {
        return $this->belongsTo(Schedule::class, 'schedule_id', 'id');
    }

    public function submitted(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by', 'id');
    }

    public function expanded_committee_information(): HasOne
    {
        return $this->hasOne(Agenda::class, 'id', 'expanded_committee');
    }

    public function other_expanded_committee_information(): HasOne
    {
        return $this->hasOne(Agenda::class, 'id', 'expanded_committee_2');
    }

    public function getFileNameAttribute(): string
    {
        return Str::afterLast(basename($this->file_path), '_');
    }

    public function getFileAttribute(): string
    {
        return basename($this->file_path);
    }
}
