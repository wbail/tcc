<?php

namespace App\Policies;

use App\User;
use App\AnoLetivo;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnoLetivoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the anoLetivo.
     *
     * @param  \App\User  $user
     * @param  \App\AnoLetivo  $anoLetivo
     * @return mixed
     */
    public function view(User $user, AnoLetivo $anoLetivo)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }

    /**
     * Determine whether the user can create anoLetivos.
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
     * Determine whether the user can update the anoLetivo.
     *
     * @param  \App\User  $user
     * @param  \App\AnoLetivo  $anoLetivo
     * @return mixed
     */
    public function update(User $user, AnoLetivo $anoLetivo)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }

    /**
     * Determine whether the user can delete the anoLetivo.
     *
     * @param  \App\User  $user
     * @param  \App\AnoLetivo  $anoLetivo
     * @return mixed
     */
    public function delete(User $user, AnoLetivo $anoLetivo)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }
}
