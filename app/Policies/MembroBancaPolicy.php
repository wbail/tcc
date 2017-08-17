<?php

namespace App\Policies;

use App\User;
use App\MembroBanca;
use Illuminate\Auth\Access\HandlesAuthorization;

class MembroBancaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the membroBanca.
     *
     * @param  \App\User  $user
     * @param  \App\MembroBanca  $membroBanca
     * @return mixed
     */
    public function view(User $user, MembroBanca $membroBanca)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }

    /**
     * Determine whether the user can create membroBancas.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }

    /**
     * Determine whether the user can update the membroBanca.
     *
     * @param  \App\User  $user
     * @param  \App\MembroBanca  $membroBanca
     * @return mixed
     */
    public function update(User $user, MembroBanca $membroBanca)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }

    /**
     * Determine whether the user can delete the membroBanca.
     *
     * @param  \App\User  $user
     * @param  \App\MembroBanca  $membroBanca
     * @return mixed
     */
    public function delete(User $user, MembroBanca $membroBanca)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }
}
