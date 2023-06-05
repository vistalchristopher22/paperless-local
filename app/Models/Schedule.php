<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $casts = [
        'date_and_time' => 'datetime',
    ];

    public function committees()
    {
        return $this->hasMany(Committee::class, 'schedule_id', 'id')->orderBy('display_index', 'ASC');
    }
}
