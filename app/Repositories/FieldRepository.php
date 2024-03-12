<?php

namespace App\Repositories;

use App\Models\Field;

class FieldRepository extends RepositoryAbstract
{
    /**
     * @return string
     */
    public function model()
    {
        return Field::class;
    }
}
