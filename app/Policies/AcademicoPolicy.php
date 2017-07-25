<?php

namespace App\Policies;

use App\User;
use App\Academico;
use Illuminate\Auth\Access\HandlesAuthorization;

class AcademicoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the academico.
     *
     * @param  \App\User  $user
     * @param  \App\Academico  $academico
     * @return mixed
     */
    public function view(User $user, Academico $academico)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }

    /**
     * Determine whether the user can create academicos.
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
     * Determine whether the user can update the academico.
     *
     * @param  \App\User  $user
     * @param  \App\Academico  $academico
     * @return mixed
     */
    public function update(User $user, Academico $academico)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }

    /**
     * Determine whether the user can delete the academico.
     *
     * @param  \App\User  $user
     * @param  \App\Academico  $academico
     * @return mixed
     */
    public function delete(User $user, Academico $academico)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }
}
