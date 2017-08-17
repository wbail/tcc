<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoordenadorCurso extends Model
{
    protected $fillable = ['inicio_vigencia', 'fim_vigencia'];
}
