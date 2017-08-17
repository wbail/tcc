<?php

namespace App\Policies;

use App\User;
use App\Arquivo;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArquivoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the arquivo.
     *
     * @param  \App\User  $user
     * @param  \App\Arquivo  $arquivo
     * @return mixed
     */
    public function view(User $user, Arquivo $arquivo)
    {
        return $user->id == $arquivo->user_id;
    }

    /**
     * Determine whether the user can create arquivos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the arquivo.
     *
     * @param  \App\User  $user
     * @param  \App\Arquivo  $arquivo
     * @return mixed
     */
    public function update(User $user, Arquivo $arquivo)
    {
        //
    }

    /**
     * Determine whether the user can delete the arquivo.
     *
     * @param  \App\User  $user
     * @param  \App\Arquivo  $arquivo
     * @return mixed
     */
    public function delete(User $user, Arquivo $arquivo)
    {
        //
    }
}
