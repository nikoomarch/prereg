<?php

namespace App\Repositories;

use App\Models\Selection;

class SelectionRepository extends RepositoryAbstract
{
    /**
     * @return string
     */
    public function model()
    {
        return Selection::class;
    }

    public function getFieldActiveSelection($fieldId)
    {
        return $this->model->query()
            ->whereRelation('field','id','=', $fieldId)
            ->where('is_active', true)
            ->first();
    }

    public function deactiveFieldSelections($fieldId)
    {
        return $this->model->query()
            ->where('field_id', $fieldId)
            ->update(['is_active' => false]);
    }

}
