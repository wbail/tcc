<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnoLetivo extends Model
{
    protected $fillable = ['rotulo', 'data', 'ativo'];

    public function trabalho() {
        return $this->hasMany(Trabalho::class);
    }

    public function academicotrabalho() {
        return $this->hasMany(AcademicoTrabalho::class);
    }
}
