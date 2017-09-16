<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabalho extends Model
{
    protected $fillable = ['titulo', 'aprovado', 'ano', 'periodo'];

    public function membrobanca() {
        return $this->belongsTo(MembroBanca::class, 'orientador_id');
    }

    public function coorientador() {
    	return $this->belongsTo(MembroBanca::class, 'coorientador_id');
    }

    public function academico() {
    	return $this->belongsToMany(Academico::class, 'academico_trabalhos')
            ->withTimestamps();
    }

    public function etapaano() {
    	return $this->belongsToMany(EtapaAno::class, 'etapa_trabalhos', 'etapaano_id', 'trabalho_id')
            ->withPivot('etapaano_id', 'trabalho_id')
            ->withTimestamps();
    }

    public function banca() {
        return $this->hasMany(Banca::class);
    }

    public function anoletivo() {
        return $this->belongsTo(AnoLetivo::class);
    }

    public function academicotrabalho() {
        return $this->belongsTo(AcademicoTrabalho::class);
    }
}
