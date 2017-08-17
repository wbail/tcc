<?php

namespace App\Policies;

use App\User;
use App\Departamento;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartamentoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the departamento.
     *
     * @param  \App\User  $user
     * @param  \App\Departamento  $departamento
     * @return mixed
     */
    public function view(User $user, Departamento $departamento)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }

    /**
     * Determine whether the user can create departamentos.
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
     * Determine whether the user can update the departamento.
     *
     * @param  \App\User  $user
     * @param  \App\Departamento  $departamento
     * @return mixed
     */
    public function update(User $user, Departamento $departamento)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }

    /**
     * Determine whether the user can delete the departamento.
     *
     * @param  \App\User  $user
     * @param  \App\Departamento  $departamento
     * @return mixed
     */
    public function delete(User $user, Departamento $departamento)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }
}
