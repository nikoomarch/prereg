<?php

namespace App\Repositories;

use App\Models\Course;

class CourseRepository extends RepositoryAbstract
{
    /**
     * @return string
     */
    public function model()
    {
        return Course::class;
    }

    public function findMany($ids)
    {
        return $this->model->query()
            ->findMany($ids);
    }

    public function getStudentRegisteredCourses($userId, $selectionId)
    {
        return $this->model->query()
            ->whereRelation('students','users.id','=', $userId)
            ->whereRelation('students','student_courses.selection_id','=', $selectionId)
            ->get();
    }
}
