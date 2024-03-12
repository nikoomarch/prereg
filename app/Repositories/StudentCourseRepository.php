<?php

namespace App\Repositories;

use App\Models\StudentCourse;
use Illuminate\Support\Facades\DB;

class StudentCourseRepository extends RepositoryAbstract
{
    /**
     * @return string
     */
    public function model()
    {
        return StudentCourse::class;
    }

    public function getRegisteredCountByCourse($selectionId, $gender)
    {
        return $this->model->query()
            ->select('course_id', DB::raw('COUNT(*) AS total'))
            ->where('selection_id',$selectionId)
            ->whereRelation('user', 'gender', '=',$gender)
            ->with(['course'])
            ->groupBy('course_id')
            ->orderBy('total', 'desc')
            ->get();
    }

    public function getCoOccurredCourses($selectionId, $gender, $courseIds)
    {
        return $this->model->query()
            ->select('course_id', DB::raw('COUNT(*) AS total'))
            ->whereNotIn('course_id', $courseIds)
            ->whereIn('user_id', function ($query) use ($courseIds, $selectionId, $gender) {
                $query->select('user_id')
                    ->from('student_courses')
                    ->join('users', 'student_courses.user_id', '=', 'users.id')
                    ->where('selection_id', $selectionId)
                    ->where('gender', $gender)
                    ->whereIn('course_id', $courseIds)
                    ->groupBy('user_id')
                    ->havingRaw('COUNT(*) = ?', [count($courseIds)])
                    ->get();
            })->groupBy('course_id')
            ->orderBy('total', 'desc')
            ->with('course')
            ->get();
    }
}
