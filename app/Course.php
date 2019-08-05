<?php

namespace studentPreRegisteration;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];
    public function students ()
    {
        return $this->belongsToMany(User::class,'student_courses');
    }
}
