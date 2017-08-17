<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $fillable = [
    	'nome',
    	'sigla'
    ];

    public function instituicao()
    {
    	return $this->belongsTo(Instituicao::class);
    }

    public function curso()
    {
    	return $this->hasMany(Curso::class);
    }

    public function membrobanca()
    {
    	return $this->hasMany(MembroBanca::class);
    }

}
