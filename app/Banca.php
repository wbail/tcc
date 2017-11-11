<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banca extends Model
{
    protected $fillable = ['papel', 'data'];

    public function trabalho() {
        return $this->belongsTo(Trabalho::class);
    }

    public function membrobanca() {
        return $this->belongsToMany(MembroBanca::class, 'membro_bancas_bancas')
            ->withPivot('papel', 'membro_banca_id')
            ->withTimestamps();
    }

    public function academico() {
        return $this->belongsToMany(Academico::class, 'academico_bancas')
            ->withPivot('academico_id', 'banca_id')
            ->withTimestamps();
    }

}
