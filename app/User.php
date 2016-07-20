<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function tarefas(){
        return $this->hasMany('App\Tarefa');
    }
    
    public function categorias(){
        return $this->hasMany('App\Categoria');
    }

    public function followers(){
        return $this->belongsToMany('App\User', 'followers', 'user_id', 'follower_id');
        //return $this->belongsToMany('App\User', 'followers', 'user_id', 'follower_id')->wherePivot('accepted', '=', 'A');
            // if you want to rely on accepted field, then add this:        
    }
    
}
