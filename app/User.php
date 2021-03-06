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
        'name', 'email', 'password', 'nickname', 'lives_in', 'worked_at'
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
        return $this->hasMany('App\Tarefa')->whereIn('status', ['A', 'C'])->get();
    }
    public function tarefasConcluidas(){
        return $this->hasMany('App\Tarefa', 'doit')->where('status', 'C')->get();
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
    }


    public function followersTable(){
        return $this->hasMany('App\Follower', 'user_id', 'id');        
    }    
    
    public function countFollowers(){
        return DB::table('followers')->select('followers.*')->where('follower_id',$this->id)->count();
    }

    public function following(){
        return $this->belongsToMany('App\User', 'followers', 'user_id', 'follower_id')
                        ->where('follow',1)
                        ->orWhere('favorite', 1);        
    }

    public function notificationAtivas(){
        return $this->hasMany('App\Notification')->where([
                                                ['status','A'],
                                                ['user_id',$this->id],
                                            ])->get();
    }
}
