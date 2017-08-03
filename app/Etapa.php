<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Etapa extends Model
{
    protected $fillable = [
    	'desc',
        'banca',
    ];

    public function etapaano()
    {
    	return $this->hasMany(EtapaAno::class);
    }
}
