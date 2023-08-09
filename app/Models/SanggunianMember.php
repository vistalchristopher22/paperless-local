<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SanggunianMember extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => bcrypt($value),
        );
    }

    public function agenda_chairman()
    {
        return $this->hasMany(Agenda::class, 'chairman', 'id');
    }

    public function agenda_vice_chairman()
    {
        return $this->hasMany(Agenda::class, 'vice_chairman', 'id');
    }

    public function agenda_member()
    {
        return $this->hasMany(AgendaMember::class, 'member', 'id');
    }


    public function expanded_agenda_chairman()
    {
        return $this->hasMany(Agenda::class, 'chairman', 'id');
    }

    public function expanded_agenda_vice_chairman()
    {
        return $this->hasMany(Agenda::class, 'vice_chairman', 'id');
    }

    public function expanded_agenda_member()
    {
        return $this->hasMany(AgendaMember::class, 'member', 'id');
    }

    public function legislations()
    {
        return $this->belongsToMany(Legislation::class, 'legislation_sponsors', 'sanggunian_member_id', 'legislation_id')->withTimestamps();
    }
}
