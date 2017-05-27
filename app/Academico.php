<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Academico extends Model
{
    protected $fillable = ['ra'];

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function curso() {
    	return $this->belongsTo(Curso::class);
    }

    public function trabalho() {
    	return $this->belongsToMany(Trabalho::class, 'academico_trabalhos', 'trabalho_id', 'academico_id')
    				->withPivot('trabalho_id', 'academico_id')
                    ->withTimestamps();
    }

}
