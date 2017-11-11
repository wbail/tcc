<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MembroBanca extends Model
{
    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function departamento() {
    	return $this->belongsTo(Departamento::class);
    }

    public function curso() {
    	return $this->belongsToMany(Curso::class, 'coordenador_cursos', 'curso_id', 'coordenador_id', 'inicio_vigencia', 'fim_vigencia')
    				->withPivot('coordenador_id', 'curso_id', 'inicio_vigencia', 'fim_vigencia')
                    ->withTimestamps();
    }

    public function trabalho() {
        return $this->hasMany(Trabalho::class, 'orientador_id');
    }

    public function etapaano() {
        return $this->belongsToMany(EtapaAno::class, 'bancas', 'papel', 'data', 'membrobanca_id', 'etapatrabalho_id')
    				->withPivot('papel', 'data', 'membrobanca_id', 'trabalho_id')
                    ->withTimestamps();
    }

    public function banca() {
        return $this->belongsToMany(Banca::class, 'membro_bancas_bancas')
            ->withPivot('papel', 'membro_banca_id')
            ->withTimestamps();
    }
}
