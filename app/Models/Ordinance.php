<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ordinance extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function legislation(): MorphOne
    {
        return $this->morphOne(Legislation::class, 'legislable');
    }
}
