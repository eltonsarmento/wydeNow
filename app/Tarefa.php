<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model{
    
    public function user(){
        return $this->belongsTo('App\User');
    }    

    protected $fillable = array('texto','status','privado');

   	public function suggestions(){
        return $this->hasMany('App\Suggestion');
    } 
}
