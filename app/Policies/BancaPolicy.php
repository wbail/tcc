<?php

namespace App\Policies;

use App\User;
use App\Banca;
use Illuminate\Auth\Access\HandlesAuthorization;

class BancaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the banca.
     *
     * @param  \App\User  $user
     * @param  \App\Banca  $banca
     * @return mixed
     */
    public function view(User $user, Banca $banca)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }

    /**
     * Determine whether the user can create bancas.
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
     * Determine whether the user can update the banca.
     *
     * @param  \App\User  $user
     * @param  \App\Banca  $banca
     * @return mixed
     */
    public function update(User $user, Banca $banca)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }

    /**
     * Determine whether the user can delete the banca.
     *
     * @param  \App\User  $user
     * @param  \App\Banca  $banca
     * @return mixed
     */
    public function delete(User $user, Banca $banca)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }
}
