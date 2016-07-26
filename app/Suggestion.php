<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model {    
	
    protected $fillable = ['texto', 'status'];

    public function Tarefa(){
        return $this->belongsTo('App\Tarefa');
    }

    public function User(){
        return $this->belongsTo('App\User');
    }
}
