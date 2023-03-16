<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Committee extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function lead_committee_information()
    {
        return $this->hasOne(Agenda::class, 'id', 'lead_committee');
    }

    public function expanded_committee_information()
    {
        return $this->hasOne(Agenda::class, 'id', 'expanded_committee');
    }
}
