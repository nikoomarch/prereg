<?php

namespace studentPreRegisteration;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $guarded = [];

    public function courses()
    {
        return $this->hasMany(Course::class)->select('id','name','unit','field_id');
    }

    public function selection()
    {
        return $this->hasOne(Selection::class);
    }

    public function terms()
    {
        return $this->belongsToMany(Term::class,'selections');
    }
}
