<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserNotification extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function sender_information()
    {
        return $this->belongsTo(User::class, 'submitted_by', 'id');
    }
}
