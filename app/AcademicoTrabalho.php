<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcademicoTrabalho extends Model
{
    protected $fillable = ['aprovado'];

    public function banca() {
        return $this->hasMany(Banca::class);
    }

    public function trabalho() {
        return $this->belongsTo(Trabalho::class);
    }

}
