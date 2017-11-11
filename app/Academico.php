<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Academico extends Model
{
    protected $fillable = ['ra'];

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function curso() {
    	return $this->belongsTo(Curso::class);
    }

    public function anoletivo() {
        return $this->belongsToMany(AnoLetivo::class, 'academico_trabalhos', 'academico_id', 'ano_letivo_id', 'trabalho_id')
            ->withPivot('aprovado')
            ->withTimestamps();
    }

    public function trabalho() {
        return $this->belongsToMany(Trabalho::class, 'academico_trabalhos')
            ->withTimestamps();
    }

    public function banca() {
        return $this->belongsToMany(Academico::class, 'academico_bancas')
            ->withPivot('academico_id', 'banca_id')
            ->withTimestamps();
    }

}
