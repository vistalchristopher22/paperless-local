<?php

namespace App\Models\LegislativeAttendance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $with = ['sanggunian_member'];

    public function sanggunian_member()
    {
        return $this->belongsTo('App\Models\SanggunianMember', 'sanggunian_member_id', 'unique_id');
    }
}
