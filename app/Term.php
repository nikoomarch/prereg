<?php

namespace studentPreRegisteration;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'code';

    public function getRouteKeyName()
    {
        return 'code';
    }
}
