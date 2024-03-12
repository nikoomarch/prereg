<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name','unit','field_id'];

    public function students()
    {
        return $this->belongsToMany(User::class,'student_courses');
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}
