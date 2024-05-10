<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Committee extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table   = 'committees';
    public $appends = [
        'file_name',
        'file',
        'submitted_at',
    ];
    public $casts   = [
        'date'             => 'date',
        'session_schedule' => 'date',
    ];
    protected $guarded = [];

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

    public function display(): MorphOne
    {
        return $this->morphOne(ScreenDisplay::class, 'screen_displayable');
    }

    public function getFileNameAttribute(): string
    {
        return Str::afterLast(basename($this->file_path ?? ""), '_');
    }

    public function getFileAttribute(): string
    {
        return basename($this->file_path ?? "");
    }

    public function file_link()
    {
        return $this->hasOne(CommitteeFileLink::class)->latestOfMany();
    }

    public function committee_invited_guests()
    {
        return $this->hasMany(CommitteeInvitedGuest::class);
    }

    protected function submittedAt(): Attribute
    {
        if (array_key_exists('created_at', $this->attributes)) {
            return Attribute::make(
                get: fn ($_) => $this->created_at->format('F d, Y h:i A'),
            );
        }

        return Attribute::make(
            get: fn ($_) => null,
        );
    }
}
