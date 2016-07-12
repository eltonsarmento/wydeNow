<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use Auth;
use Image;

class UserController extends Controller{


    public function profile($categoriaDefault = "Pessoal"){        
        $user = Auth::user();     
        
        foreach ($user->tarefas as $key => $t) {
            $dt = new Carbon($t->created_at, 'America/Maceio');
            $user->tarefas[$key]['tempoCadastada'] = $dt->diffForHumans(Carbon::now('America/Maceio')); 
        
        }
        
    	return view('profile', array('user' => $user, 'categoriaSetada' => $categoriaDefault));
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

     public function add_categoria(Request $request){

        if($request->has('categoria')){
            $texto = $request->input('categoria');

            $categoria = new Categoria;
            $categoria->user_id = Auth::user()->id;            
            $categoria->texto = $texto;
            //$categoria->save();
        }
        
        return redirect('/profile');
    }
    
}
