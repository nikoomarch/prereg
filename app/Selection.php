<?php

namespace studentPreRegisteration;

use Illuminate\Database\Eloquent\Model;

class Selection extends Model
{
    protected $guarded = [];

    protected $casts = [
        'terms' => 'array'
    ];

    public function terms()
    {
        return $this->belongsToMany(Term::class, 'selection_terms')->select('id', 'code');
    }

    public function setStartDateAttribute($value)
    {
        $this->attributes['startDate'] = $value == null ? $value : date('Y-m-d', $value);
    }

    public function setEndDateAttribute($value)
    {
        $this->attributes['endDate'] = $value == null ? $value : date('Y-m-d', $value);
    }
}
