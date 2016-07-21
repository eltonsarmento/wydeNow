<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model{
    
    public function categorias(){
        return $this->belongsToMany('App\Categoria', 'follower_categoria', 'categoria_id', 'follower_id');    
    }

}
