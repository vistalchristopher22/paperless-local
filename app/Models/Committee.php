<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Committee extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Searchable;

    protected $guarded = [];
    public $appends = [
        'file_name',
        'file'
    ];

    public function lead_committee_information()
    {
        return $this->hasOne(Agenda::class, 'id', 'lead_committee');
    }

    public function expanded_committee_information()
    {
        return $this->hasOne(Agenda::class, 'id', 'expanded_committee');
    }

    public function getFileNameAttribute()
    {
        return Str::afterLast(basename($this->file_path), "_");
    }

    public function getFileAttribute()
    {
        return basename($this->file_path);
    }

    public function toSearchableArray()
    {
        return [
            'content' => $this->content,
        ];
    }
}
