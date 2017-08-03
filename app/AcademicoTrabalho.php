<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcademicoTrabalho extends Model
{
    public function banca() {
        return $this->hasMany(Banca::class);
    }
}
