<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model{
    
    public function user(){
        return $this->belongsTo('estoque\User');
    }    

    protected $fillable = array('texto','status','privado');
}
