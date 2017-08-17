<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    protected $fillable = ['tipo', 'numero'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
