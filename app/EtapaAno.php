<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EtapaAno extends Model
{
    protected $fillable = ['titulo', 'data_inicial', 'data_final', 'ativa'];

    public function etapa() {
    	return $this->belongsTo(Etapa::class);
    }

    public function trabalho() {
    	return $this->belongsToMany(EtapaAno::class, 'etapa_trabalhos', 'etapaano_id', 'trabalho_id')
    				->withPivot('etapaano_id', 'trabalho_id')
    				->withTimestamps();
    }

    public function membrobanca() {
        return $this->belongsToMany(MembroBanca::class, 'bancas', 'papel', 'data', 'membrobanca_id', 'etapatrabalho_id')
    				->withPivot('papel', 'data', 'membrobanca_id', 'trabalho_id')
                    ->withTimestamps();
    }

}
