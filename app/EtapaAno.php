<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EtapaAno extends Model
{
    protected $fillable = ['titulo', 'data_inicial', 'data_final', 'ativa'];

    public function etapa() {
    	return $this->belongsTo(Etapa::class);
    }
}
