<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardSessionCommitteeLink extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function board_session()
    {
        return $this->belongsTo(BoardSession::class);
    }
}
