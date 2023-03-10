<?php

namespace App\Models;

use App\Models\SanggunianMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgendaMember extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function sanggunian_member()
    {
        return $this->hasMany(SanggunianMember::class, 'id', 'member');
    }
}
