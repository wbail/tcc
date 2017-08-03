<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EtapaTrabalho extends Model
{
    protected $fillable = ['excecao'];

    public function user() {
        return $this->belongsToMany(Arquivo::class, 'arquivos', 'user_id', 'etapatrabalho_id')
                    ->withPivot('user_id', 'etapatrabalho_id')
                    ->withTimestamps();
    }

    public function membrobanca() {
        return $this->belongsToMany(MembroBanca::class, 'bancas', 'papel', 'membrobanca_id', 'etapatrabalho_id')
    				->withPivot('papel', 'membrobanca_id', 'etapatrabalho_id')
                    ->withTimestamps();
    }
}
