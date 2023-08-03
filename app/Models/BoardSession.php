<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardSession extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function schedule_information()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id', 'id');
    }


}
