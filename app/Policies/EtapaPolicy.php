<?php

namespace App\Policies;

use App\User;
use App\Etapa;
use Illuminate\Auth\Access\HandlesAuthorization;

class EtapaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the etapa.
     *
     * @param  \App\User  $user
     * @param  \App\Etapa  $etapa
     * @return mixed
     */
    public function view(User $user, Etapa $etapa)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }

    /**
     * Determine whether the user can create etapas.
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
     * Determine whether the user can update the etapa.
     *
     * @param  \App\User  $user
     * @param  \App\Etapa  $etapa
     * @return mixed
     */
    public function update(User $user, Etapa $etapa)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }

    /**
     * Determine whether the user can delete the etapa.
     *
     * @param  \App\User  $user
     * @param  \App\Etapa  $etapa
     * @return mixed
     */
    public function delete(User $user, Etapa $etapa)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }
}
