<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaMember extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function sanggunian_member()
    {
        return $this->hasMany(SanggunianMember::class, 'id', 'member');
    }

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }
}
