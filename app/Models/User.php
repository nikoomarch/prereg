<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'family', 'field_id', 'role', 'username', 'password', 'gender', 'national_code', 'entrance_term_id', 'is_allowed'
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

    public function gender(): Attribute
    {
        $cast = [
            'M' => 'M',
            'F' => 'F',
            'مرد' => 'M',
            'زن' => 'F'
        ];
        return Attribute::make(
            set: fn (string $value) => $cast[$value]
        );
    }

    public function registeredCourses()
    {
        return $this->belongsToMany(Course::class, 'student_courses');
    }

    public function entranceTerm()
    {
        return $this->belongsTo(Term::class, 'entrance_term_id');
    }
}
