<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Curso extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    protected $fillable = ['nome', 'coordenador_id', 'curso_id'];

    public function departamento() {
    	return $this->belongsTo(Departamento::class);
    }

    public function academico() {
    	return $this->hasMany(Academico::class);
    }

    public function membrobanca() {
    	return $this->belongsToMany(MembroBanca::class, 'coordenador_cursos', 'curso_id', 'coordenador_id', 'inicio_vigencia', 'fim_vigencia')
                    ->withPivot('coordenador_id', 'curso_id', 'inicio_vigencia', 'fim_vigencia')
                    ->withTimestamps();
    }
}
