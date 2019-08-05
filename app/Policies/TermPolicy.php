<?php

namespace studentPreRegisteration\Policies;

use studentPreRegisteration\User;
use studentPreRegisteration\Term;
use Illuminate\Auth\Access\HandlesAuthorization;

class TermPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any terms.
     *
     * @param  \studentPreRegisteration\User  $user
     * @return mixed
     */
    public function viewAll(User $user)
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can view the term.
     *
     * @param  \studentPreRegisteration\User  $user
     * @param  \studentPreRegisteration\Term  $term
     * @return mixed
     */
    public function view(User $user, Term $term)
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can create terms.
     *
     * @param  \studentPreRegisteration\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can update the term.
     *
     * @param  \studentPreRegisteration\User  $user
     * @param  \studentPreRegisteration\Term  $term
     * @return mixed
     */
    public function update(User $user, Term $term)
    {
        //
    }

    /**
     * Determine whether the user can delete the term.
     *
     * @param  \studentPreRegisteration\User  $user
     * @param  \studentPreRegisteration\Term  $term
     * @return mixed
     */
    public function delete(User $user, Term $term)
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can restore the term.
     *
     * @param  \studentPreRegisteration\User  $user
     * @param  \studentPreRegisteration\Term  $term
     * @return mixed
     */
    public function restore(User $user, Term $term)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the term.
     *
     * @param  \studentPreRegisteration\User  $user
     * @param  \studentPreRegisteration\Term  $term
     * @return mixed
     */
    public function forceDelete(User $user, Term $term)
    {
        //
    }
}
