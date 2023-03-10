<?php

namespace App\Models;

use App\Models\AgendaMember;
use App\Models\SanggunianMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
