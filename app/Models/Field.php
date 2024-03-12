<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $fillable = ['name'];

    public function courses()
    {
        return $this->hasMany(Course::class)->select('id','name','unit','field_id');
    }

    public function selections()
    {
        return $this->hasMany(Selection::class);
    }

    public function terms()
    {
        return $this->belongsToMany(Term::class,'selections');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
