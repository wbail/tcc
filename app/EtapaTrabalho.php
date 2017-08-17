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
}
