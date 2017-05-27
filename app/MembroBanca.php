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
        return $this->belongsToMany(Trabalho::class, 'orientador_id', 'coorientador_id');
    }
}
