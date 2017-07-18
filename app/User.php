<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mudou_senha',
        'permissao',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function arquivo() {
        return $this->hasMany(Arquivo::class);
    }

    public function academico() {
        return $this->hasMany(Academico::class);
    }

    public function membrobanca() {
        return $this->hasMany(MembroBanca::class);
    }

    public function telefone() {
        return $this->hasMany(Telefone::class);
    }

    public static function userMembroDepartamento () {
        return User::find(Auth::user()->id)
                    ->membrobanca()
                    ->first();
                    
    }

}
