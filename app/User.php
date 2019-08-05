<?php

namespace studentPreRegisteration;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'family' , 'field_id', 'role' , 'username', 'password', 'gender','nationalCode', 'entranceTerm'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function setGenderAttribute($value)
    {
        if($value == null)
        $this->attributes['gender'] = null;
        elseif($value == 'زن')
            $this->attributes['gender'] = 'F';
        elseif ($value == 'مرد')
            $this->attributes['gender'] = 'M';
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class,'student_courses');
    }
}