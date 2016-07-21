<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use App\User;
use App\categoria;
use App\Tarefa;
use Auth;
use Image;

class UserController extends Controller{

	public function index($nickname = Null){        

		if(empty($nickname)){
			$user = Auth::user();
			$follower = null;
			$my_perfil = true;
		}else{
        	$vUser = User::where('nickname',$nickname)->get();
        	$user = $vUser[0];

        	$vFollower = Auth::user()->followers()->where('follower_id',$user->id)->get();	        
	        $follower = (empty($vFollower[0]) ? null : $vFollower[0]);
	        $my_perfil = false;
    	}
       
       	
        $categoriaDefault = "Pessoal";
        $vCategoria = categoria::where(
                [
                    ['user_id', $user->id],
                    ['descricao', $categoriaDefault],
                ]            
            )->get();
        $categoria = $vCategoria[0];
        
       
        $campoOrdenacao = "created_at";
        $order = "asc";
        $tarefasAtivas = Tarefa::where(
                [
                    ['user_id', $user->id],
                    ['categoria_id', $categoria->id],
                    ['status', 'A'],
                ]            
            )->orderBy($campoOrdenacao, $order)->get();        

        
        $user->tarefas = $tarefasAtivas;
        foreach ($user->tarefas as $key => $t) {
            $dt = new Carbon($t->created_at, 'America/Maceio');
            $user->tarefas[$key]['tempoCadastada'] = $dt->diffForHumans(Carbon::now('America/Maceio'));         
        }
        
        if(Auth::user()->followers()->count() == 0)
            $people = User::where('id','<>', Auth::user()->id)->take(5)->get();

        return view('profile', array(
                 'user' => $user, 
                 'categoriaSetada' => $categoriaDefault,
                 'my_perfil' => $my_perfil,
                 'follower' => $follower,
                 'people' => $people,
        ));
    }
    

    
    public function update_avatar(Request $request){

    	if($request->hasFile('avatar')){
			$avatar = $request->file('avatar');
			$filename = time() . '.' . $avatar->getClientOriginalExtension();
			Image::make($avatar)->resize(300,300)->save( public_path('/uploads/avatars/'.$filename));

			$user = Auth::user();
			$user->avatar = $filename;
			$user->save();
    	}

    	return view('profile', array('user' => Auth::user()));
    }

     
    
}
