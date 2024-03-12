<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class SelectionFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function field($field_id)
    {
        return $this->whereRelation('field','id','=', $field_id);
    }
}
