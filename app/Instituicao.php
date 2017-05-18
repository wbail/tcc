<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instituicao extends Model
{
    protected $fillable = [
    	'nome',
    	'sigla',
    ];

    public function departamento()
    {
    	return $this->hasMany(Departamento::class);
    }
}
