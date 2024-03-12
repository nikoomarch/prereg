<?php

namespace App\Repositories;

use App\Models\Term;

class TermRepository extends RepositoryAbstract
{
    /**
     * @return string
     */
    public function model()
    {
        return Term::class;
    }
}
