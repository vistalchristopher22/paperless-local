<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardSessionCommitteeLink extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $appends = [
        'name'
    ];

    public function board_session()
    {
        return $this->belongsTo(BoardSession::class);
    }

    public function getNameAttribute()
    {
        return basename($this->public_path ?? "");
    }
}
