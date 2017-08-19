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

    public function academicotrabalho() {
        return $this->hasMany(AcademicoTrabalho::class);
    }
}
