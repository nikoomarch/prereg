<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Selection;
use Illuminate\Auth\Access\HandlesAuthorization;

class SelectionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any selections.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasRole('group_manager');
    }

    /**
     * Determine whether the user can view the selection.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Selection  $selection
     * @return mixed
     */
    public function view(User $user, Selection $selection)
    {
        return $user->hasRole('group_manager');
    }

    /**
     * Determine whether the user can create selections.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole('group_manager');
    }

    /**
     * Determine whether the user can update the selection.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Selection  $selection
     * @return mixed
     */
    public function update(User $user, Selection $selection)
    {
        return $user->hasRole('group_manager');
    }

    /**
     * Determine whether the user can delete the selection.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Selection  $selection
     * @return mixed
     */
    public function delete(User $user, Selection $selection)
    {
        return $user->hasRole('group_manager');
    }

    /**
     * Determine whether the user can restore the selection.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Selection  $selection
     * @return mixed
     */
    public function restore(User $user, Selection $selection)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the selection.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Selection  $selection
     * @return mixed
     */
    public function forceDelete(User $user, Selection $selection)
    {
        //
    }
}
