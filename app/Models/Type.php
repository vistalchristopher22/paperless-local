<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Type extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];


    protected $fillable = ['name'];

}
