<?php

namespace App\Models;

use App\Enums\UserStatus;
use App\FormRules\UserFormRules;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Laravel\Pennant\Concerns\HasFeatures;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use HasFeatures;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'username',
        'password',
        'account_type',
        'status',
        'profile_picture',
        'division',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => UserStatus::class,
    ];

    public $appends = [
        'fullname'
    ];



    protected function fullname(): Attribute
    {
        return Attribute::make(
            get: fn ($_) => $this->first_name . ' ' . $this->last_name,
        );
    }


    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => bcrypt($value),
        );
    }

    public function division_information()
    {
        return $this->hasOne(Division::class, 'id', 'division');
    }

    public function access()
    {
        return $this->hasMany(UserAccess::class, 'user', 'id');
    }

    public function committee()
    {
        return $this->hasOne(User::class, 'submitted_by', 'id');
    }

    public function login_histories()
    {
        return $this->hasOne(LoginHistory::class);
    }
}
