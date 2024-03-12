<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository extends RepositoryAbstract
{
    /**
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    public function updateStudentsPermission($search, $isAllowed)
    {
        return $this->model->query()
            ->filter($search)
            ->whereHas('roles',fn($query) => $query->where('name', 'student'))
            ->update(['is_allowed' => $isAllowed]);
    }

    public function count($search)
    {
        return $this->model->query()
            ->filter($search)
            ->count();
    }

    public function bulkDelete($search)
    {
        return $this->model->query()
            ->filter($search)
            ->delete();
    }

    public function getRegisteredCountByTerm($selectionId, $courseIds)
    {
        return $this->model->query()
            ->select('entrance_term_id', DB::raw("COUNT(IF(gender='M',1, NULL)) 'Male'"), DB::raw("COUNT(IF(gender='F',1, NULL)) 'Female'"))
            ->whereRelation('roles', 'name','=','student')
            ->filter([
                'has_registered_in_selection' => $selectionId,
                'has_registered_courses' => $courseIds,
            ])
            ->groupBy('entrance_term_id')
            ->with('entranceTerm')
            ->get();
    }

    public function paginateRegisteredStudents($selectionId, $gender, $courseIds, $limit=25)
    {
        return $this->model->query()
            ->whereRelation('roles', 'name','=','student')
            ->filter([
                'gender' => $gender,
                'has_registered_in_selection' => $selectionId,
                'has_registered_courses' => $courseIds,
            ])
            ->paginate($limit);
    }
}
