<?php

namespace App\Policies;

use App\User;
use App\Trabalho;
use Illuminate\Auth\Access\HandlesAuthorization;

class TrabalhoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the trabalho.
     *
     * @param  \App\User  $user
     * @param  \App\Trabalho  $trabalho
     * @return mixed
     */
    public function view(User $user, Trabalho $trabalho)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }

    /**
     * Determine whether the user can create trabalhos.
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
     * Determine whether the user can update the trabalho.
     *
     * @param  \App\User  $user
     * @param  \App\Trabalho  $trabalho
     * @return mixed
     */
    public function update(User $user, Trabalho $trabalho)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }

    /**
     * Determine whether the user can delete the trabalho.
     *
     * @param  \App\User  $user
     * @param  \App\Trabalho  $trabalho
     * @return mixed
     */
    public function delete(User $user, Trabalho $trabalho)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }
}
