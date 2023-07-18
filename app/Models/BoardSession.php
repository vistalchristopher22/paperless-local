<?php

namespace App\Models;

use App\Enums\BoardSessionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardSession extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        parent::updating(callback: function ($boardSession) {
            if ($boardSession->status == BoardSessionStatus::LOCKED->value) {
                return false;
            }
        });
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id', 'id');
    }


}
