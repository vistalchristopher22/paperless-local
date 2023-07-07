<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Committee extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $connection = 'sqlsrv';

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

    public function lead_committee_information()
    {
        return $this->hasOne(Agenda::class, 'id', 'lead_committee');
    }

    public function submitted()
    {
        return $this->belongsTo(User::class, 'submitted_by', 'id');
    }

    public function expanded_committee_information()
    {
        return $this->hasOne(Agenda::class, 'id', 'expanded_committee');
    }

    public function getFileNameAttribute()
    {
        return Str::afterLast(basename($this->file_path), '_');
    }

    public function getFileAttribute()
    {
        return basename($this->file_path);
    }
}
