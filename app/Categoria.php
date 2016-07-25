<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model{
    
    public function user(){
        return $this->belongsTo('App\User');
    }

    protected $fillable = [
        'descricao', 'user_id', 'status', 'posicao'
    ];
}
