<?php

namespace App\Models\LegislativeAttendance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model
{
    use HasFactory;
    protected $fillable = ['rf_assigned', 'rfid_card_no', 'date', 'time'];

    public $connection = 'tsp_attendance';
    public $table = 'students';
}
