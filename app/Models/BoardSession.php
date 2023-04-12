<?php

namespace App\Models;

use App\FormRules\BoardSessionFormRules;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BoardSession extends Model
{
    use HasFactory;
    use SoftDeletes;
    use BoardSessionFormRules;
    protected $guarded = [];
}
