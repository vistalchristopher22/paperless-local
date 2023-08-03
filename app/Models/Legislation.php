<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Legislation extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = ['id', 'no', 'title', 'description', 'classification', 'created_at'];

    public function legislable()
    {
        return $this->morphTo();
    }
}
