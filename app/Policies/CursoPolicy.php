<?php

namespace App\Policies;

use App\User;
use App\Curso;
use Illuminate\Auth\Access\HandlesAuthorization;

class CursoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the curso.
     *
     * @param  \App\User  $user
     * @param  \App\Curso  $curso
     * @return mixed
     */
    public function view(User $user, Curso $curso)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }

    /**
     * Determine whether the user can create cursos.
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
     * Determine whether the user can update the curso.
     *
     * @param  \App\User  $user
     * @param  \App\Curso  $curso
     * @return mixed
     */
    public function update(User $user, Curso $curso)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }

    /**
     * Determine whether the user can delete the curso.
     *
     * @param  \App\User  $user
     * @param  \App\Curso  $curso
     * @return mixed
     */
    public function delete(User $user, Curso $curso)
    {
        if($user->permissao == 9) {
            return true;
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }
    }
}
