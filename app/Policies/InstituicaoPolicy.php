<?php

namespace App\Policies;

use App\User;
use App\Instituicao;
use Illuminate\Auth\Access\HandlesAuthorization;

class InstituicaoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the instituicao.
     *
     * @param  \App\User  $user
     * @param  \App\Instituicao  $instituicao
     * @return mixed
     */
    public function view(User $user, Instituicao $instituicao)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }

    /**
     * Determine whether the user can create instituicaos.
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
     * Determine whether the user can update the instituicao.
     *
     * @param  \App\User  $user
     * @param  \App\Instituicao  $instituicao
     * @return mixed
     */
    public function update(User $user, Instituicao $instituicao)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }

    /**
     * Determine whether the user can delete the instituicao.
     *
     * @param  \App\User  $user
     * @param  \App\Instituicao  $instituicao
     * @return mixed
     */
    public function delete(User $user, Instituicao $instituicao)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }
}
