<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabalho extends Model
{
    protected $fillable = ['titulo', 'aprovado', 'ano', 'periodo'];

    public function membrobanca() {
    	return $this->belongsToMany(MembroBanca::class, 'orientador_id', 'coorientador_id');
    }

    public function academico() {
    	return $this->belongsToMany(Academico::class, 'academico_trabalhos', 'trabalho_id', 'academico_id')
    				->withPivot('trabalho_id', 'academico_id')
                    ->withTimestamps();
    }

    public function etapaano() {
    	return $this->belongsToMany(EtapaAno::class, 'etapa_trabalhos', 'trabalho_id', 'etapaano_id')
    				->withPivot('trabalho_id', 'etapaano_id')
    				->withTimestamps();
    }

}
