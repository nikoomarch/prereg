<?php

namespace studentPreRegisteration\Policies;

use studentPreRegisteration\User;
use studentPreRegisteration\StudentCourse;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentCoursePolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any student courses.
     *
     * @param  \studentPreRegisteration\User  $user
     * @return mixed
     */
    public function viewAll(User $user)
    {
        return $user->role == 'student';
    }

    /**
     * Determine whether the user can view the student course.
     *
     * @param  \studentPreRegisteration\User  $user
     * @param  \studentPreRegisteration\StudentCourse  $studentCourse
     * @return mixed
     */
    public function view(User $user, StudentCourse $studentCourse)
    {
        return $user->role == 'student';
    }

    /**
     * Determine whether the user can create student courses.
     *
     * @param  \studentPreRegisteration\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role == 'student';
    }

    /**
     * Determine whether the user can update the student course.
     *
     * @param  \studentPreRegisteration\User  $user
     * @param  \studentPreRegisteration\StudentCourse  $studentCourse
     * @return mixed
     */
    public function update(User $user, StudentCourse $studentCourse)
    {
        return $user->role == 'student';
    }

    /**
     * Determine whether the user can delete the student course.
     *
     * @param  \studentPreRegisteration\User  $user
     * @param  \studentPreRegisteration\StudentCourse  $studentCourse
     * @return mixed
     */
    public function delete(User $user, StudentCourse $studentCourse)
    {
        return $user->role == 'student';
    }

    /**
     * Determine whether the user can restore the student course.
     *
     * @param  \studentPreRegisteration\User  $user
     * @param  \studentPreRegisteration\StudentCourse  $studentCourse
     * @return mixed
     */
    public function restore(User $user, StudentCourse $studentCourse)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the student course.
     *
     * @param  \studentPreRegisteration\User  $user
     * @param  \studentPreRegisteration\StudentCourse  $studentCourse
     * @return mixed
     */
    public function forceDelete(User $user, StudentCourse $studentCourse)
    {
        //
    }
}
