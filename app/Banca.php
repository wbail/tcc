<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banca extends Model
{
    protected $fillable = ['papel', 'data'];

    public function academicotrabalho() {
        return $this->belongsTo(AcademicoTrabalho::class);
    }
}
