<?php

namespace App\Policies;

use App\User;
use App\EtapaAno;
use Illuminate\Auth\Access\HandlesAuthorization;

class EtapaAnoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the etapaAno.
     *
     * @param  \App\User  $user
     * @param  \App\EtapaAno  $etapaAno
     * @return mixed
     */
    public function view(User $user, EtapaAno $etapaAno)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }

    /**
     * Determine whether the user can create etapaAnos.
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
     * Determine whether the user can update the etapaAno.
     *
     * @param  \App\User  $user
     * @param  \App\EtapaAno  $etapaAno
     * @return mixed
     */
    public function update(User $user, EtapaAno $etapaAno)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }

    /**
     * Determine whether the user can delete the etapaAno.
     *
     * @param  \App\User  $user
     * @param  \App\EtapaAno  $etapaAno
     * @return mixed
     */
    public function delete(User $user, EtapaAno $etapaAno)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }
}
