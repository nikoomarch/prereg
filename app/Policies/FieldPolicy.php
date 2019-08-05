<?php

namespace studentPreRegisteration\Policies;

use studentPreRegisteration\User;
use studentPreRegisteration\Field;
use Illuminate\Auth\Access\HandlesAuthorization;

class FieldPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any fields.
     *
     * @param  \studentPreRegisteration\User  $user
     * @return mixed
     */
    public function viewAll(User $user)
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can view the field.
     *
     * @param  \studentPreRegisteration\User  $user
     * @param  \studentPreRegisteration\Field  $field
     * @return mixed
     */
    public function view(User $user, Field $field)
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can create fields.
     *
     * @param  \studentPreRegisteration\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can update the field.
     *
     * @param  \studentPreRegisteration\User  $user
     * @param  \studentPreRegisteration\Field  $field
     * @return mixed
     */
    public function update(User $user, Field $field)
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can delete the field.
     *
     * @param  \studentPreRegisteration\User  $user
     * @param  \studentPreRegisteration\Field  $field
     * @return mixed
     */
    public function delete(User $user, Field $field)
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can restore the field.
     *
     * @param  \studentPreRegisteration\User  $user
     * @param  \studentPreRegisteration\Field  $field
     * @return mixed
     */
    public function restore(User $user, Field $field)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the field.
     *
     * @param  \studentPreRegisteration\User  $user
     * @param  \studentPreRegisteration\Field  $field
     * @return mixed
     */
    public function forceDelete(User $user, Field $field)
    {
        //
    }
}
