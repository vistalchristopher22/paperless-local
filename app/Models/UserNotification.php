<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function sender_information()
    {
        return $this->belongsTo(User::class, 'submitted_by', 'id');
    }
}
