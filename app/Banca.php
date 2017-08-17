<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banca extends Model
{
    protected $fillable = ['papel', 'data'];

    public function trabalho() {
        return $this->belongsTo(Trabalho::class);
    }
}
