<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnoLetivo extends Model
{
    use SoftDeletes;

    protected $fillable = ['rotulo', 'data', 'ativo', 'deleted_at'];

    public function trabalho() {
        return $this->hasMany(Trabalho::class);
    }

    public function academico() {
        return $this->belongsToMany(AnoLetivo::class, 'academico_trabalhos', 'academico_id', 'ano_letivo_id', 'trabalho_id')
            ->withPivot('aprovado')
            ->withTimestamps();
    }
}
