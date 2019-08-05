<?php

namespace studentPreRegisteration\Policies;

use studentPreRegisteration\User;
use studentPreRegisteration\Course;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any courses.
     *
     * @param  \studentPreRegisteration\User  $user
     * @return mixed
     */
    public function viewAll(User $user)
    {
        return $user->role == 'groupManager';
    }

    /**
     * Determine whether the user can view the course.
     *
     * @param  \studentPreRegisteration\User  $user
     * @param  \studentPreRegisteration\Course  $course
     * @return mixed
     */
    public function view(User $user, Course $course)
    {
        return $user->role == 'groupManager';
    }

    /**
     * Determine whether the user can create courses.
     *
     * @param  \studentPreRegisteration\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role == 'groupManager';
    }

    /**
     * Determine whether the user can update the course.
     *
     * @param  \studentPreRegisteration\User  $user
     * @param  \studentPreRegisteration\Course  $course
     * @return mixed
     */
    public function update(User $user, Course $course)
    {
        return $user->role == 'groupManager';
    }

    /**
     * Determine whether the user can delete the course.
     *
     * @param  \studentPreRegisteration\User  $user
     * @param  \studentPreRegisteration\Course  $course
     * @return mixed
     */
    public function delete(User $user, Course $course)
    {
        return $user->role == 'groupManager';
    }

    /**
     * Determine whether the user can restore the course.
     *
     * @param  \studentPreRegisteration\User  $user
     * @param  \studentPreRegisteration\Course  $course
     * @return mixed
     */
    public function restore(User $user, Course $course)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the course.
     *
     * @param  \studentPreRegisteration\User  $user
     * @param  \studentPreRegisteration\Course  $course
     * @return mixed
     */
    public function forceDelete(User $user, Course $course)
    {
        //
    }
}
