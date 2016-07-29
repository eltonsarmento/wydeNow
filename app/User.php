<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
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
    public function my_tarefas(){
        return $this->hasMany('App\Tarefa')->whereIn('status', ['A', 'C']);
    }
    public function tarefasConcluidas(){
        return $this->hasMany('App\Tarefa')->where('status', 'C');
    }
    public function tarefasPendentes(){
        return Tarefa::where([
                    ['doit', $this->id],
                    ['status', 'A'],
                ])->orderBy('created_at', 'asc')->get();
    }
    
    public function categorias(){
        return $this->hasMany('App\Categoria');
    }

    public function followers(){
        return $this->belongsToMany('App\User', 'followers', 'user_id', 'follower_id');
        //return $this->belongsToMany('App\User', 'followers', 'user_id', 'follower_id')->wherePivot('accepted', '=', 'A');
            // if you want to rely on accepted field, then add this:        
    }


    public function followersTable(){
        return $this->hasMany('App\Follower', 'user_id', 'id');
        //return $this->belongsToMany('App\User', 'followers', 'user_id', 'follower_id')->wherePivot('accepted', '=', 'A');
            // if you want to rely on accepted field, then add this:        
    }    
    
    public function countFollowers(){
        return DB::table('followers')->select('followers.*')->where('follower_id',$this->id)->count();
    }

    public function following(){
        return $this->belongsToMany('App\User', 'followers', 'user_id', 'follower_id')
                        ->where('follow',1)
                        ->orWhere('favorite', 1);
        //return $this->belongsToMany('App\User', 'followers', 'user_id', 'follower_id')->wherePivot('accepted', '=', 'A');
            // if you want to rely on accepted field, then add this:        
    }
}
