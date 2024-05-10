<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommitteeInvitedGuest extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function committee()
    {
        return $this->hasOne(Committee::class, 'id', 'committee_id');
    }
}
