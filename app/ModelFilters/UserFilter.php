<?php

namespace App\ModelFilters;

use App\Models\StudentCourse;
use EloquentFilter\ModelFilter;

class UserFilter extends ModelFilter
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

    public function role($role)
    {
        $this->whereRelation('roles','name','=', $role);
    }

    public function username($username)
    {
        return $this->where('username','=', $username);
    }

    public function gender($gender)
    {
        return $this->where('gender','=', $gender);
    }

    public function entranceTerm($entranceTerm)
    {
        return $this->where('entrance_term_id',$entranceTerm);
    }

    public function isAllowed($isAllowed)
    {
        return $this->where('is_allowed', $isAllowed);
    }

    public function hasRegisteredCourses($courseIds = [])
    {
        $registeredUserIds = StudentCourse::query()
            ->select('user_id')
            ->whereIn('course_id', $courseIds)
            ->groupBy('user_id')
            ->havingRaw('COUNT(user_id) = ?', [count($courseIds)])
            ->get();
        return $this->whereIn('id', $registeredUserIds);
    }

    public function hasRegisteredInSelection($selectionId)
    {
        return $this->whereHas('registeredCourses', fn($query) => $query->where('student_courses.selection_id','=', $selectionId), '>','0');
    }
}
