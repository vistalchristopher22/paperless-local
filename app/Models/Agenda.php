<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function chairman_information()
    {
        return $this->hasOne(SanggunianMember::class, 'id', 'chairman');
    }

    public function vice_chairman_information()
    {
        return $this->hasOne(SanggunianMember::class, 'id', 'vice_chairman');
    }

    public function members()
    {
        return $this->hasMany(AgendaMember::class, 'agenda_id', 'id');
    }
}
