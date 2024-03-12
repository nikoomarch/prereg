<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Selection extends Model
{
    use Filterable;

    protected $fillable = ['field_id','start_date','end_date','term','max','is_active'];

    protected $casts = [
        'terms' => 'array'
    ];

    public function allowedTerms()
    {
        return $this->belongsToMany(Term::class, 'selection_terms')->withPivot(['gender']);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function startDate(): Attribute
    {
        return new Attribute(
            set: fn($value) => $value == null ? $value : date('Y-m-d', $value)
        );
    }

    public function endDate(): Attribute
    {
        return new Attribute(
            set: fn($value) => $value == null ? $value : date('Y-m-d', $value)
        );
    }
}
