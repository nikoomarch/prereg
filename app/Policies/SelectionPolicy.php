<?php

namespace studentPreRegisteration\Policies;

use studentPreRegisteration\User;
use studentPreRegisteration\Selection;
use Illuminate\Auth\Access\HandlesAuthorization;

class SelectionPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any selections.
     *
     * @param  \studentPreRegisteration\User  $user
     * @return mixed
     */
    public function viewAll(User $user)
    {
        return $user->role == 'groupManager';
    }

    /**
     * Determine whether the user can view the selection.
     *
     * @param  \studentPreRegisteration\User  $user
     * @param  \studentPreRegisteration\Selection  $selection
     * @return mixed
     */
    public function view(User $user, Selection $selection)
    {
        return $user->role == 'groupManager';
    }

    /**
     * Determine whether the user can create selections.
     *
     * @param  \studentPreRegisteration\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role == 'groupManager';
    }

    /**
     * Determine whether the user can update the selection.
     *
     * @param  \studentPreRegisteration\User  $user
     * @param  \studentPreRegisteration\Selection  $selection
     * @return mixed
     */
    public function update(User $user, Selection $selection)
    {
        return $user->role == 'groupManager';
    }

    /**
     * Determine whether the user can delete the selection.
     *
     * @param  \studentPreRegisteration\User  $user
     * @param  \studentPreRegisteration\Selection  $selection
     * @return mixed
     */
    public function delete(User $user, Selection $selection)
    {
        return $user->role == 'groupManager';
    }

    /**
     * Determine whether the user can restore the selection.
     *
     * @param  \studentPreRegisteration\User  $user
     * @param  \studentPreRegisteration\Selection  $selection
     * @return mixed
     */
    public function restore(User $user, Selection $selection)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the selection.
     *
     * @param  \studentPreRegisteration\User  $user
     * @param  \studentPreRegisteration\Selection  $selection
     * @return mixed
     */
    public function forceDelete(User $user, Selection $selection)
    {
        //
    }
}
