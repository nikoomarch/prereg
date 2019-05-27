<?php

namespace studentPreRegisteration;

use Illuminate\Database\Eloquent\Model;

class StudentCourse extends Model
{
    protected $fillable = [
        'user_id', 'course_id'
    ];
}
