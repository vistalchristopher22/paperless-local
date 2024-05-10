<?php

namespace App\Models\LegislativeAttendance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardMemberIdentificationCard extends Model
{
    use HasFactory;

    public $connection = 'tsp_attendance';
    public $table = 'students';

    protected $fillable = ['affiliates', 'lname', 'fname', 'mname', 'course', 'level', 'address', 'mobile', 'reg_date', 'photo', 'rfidno', 'rfidno2', 'sguest', 'sdate'];
}
