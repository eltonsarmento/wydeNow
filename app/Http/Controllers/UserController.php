<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Request;
use App\Http\Requests;
use Carbon\Carbon;
use App\User;
use App\categoria;
use App\Tarefa;
use Auth;
use DB;
use Image;

class UserController extends Controller{

	public function index($nickname = Null, $categoriaDefault = "Pessoal"){        


		if(empty($nickname)){
			$user = Auth::user();
			$follower = null;
			$my_perfil = true;

		}else{
        	$vUser = User::where('nickname',$nickname)->get();
        	$user = $vUser[0];

        	//$vFollower = Auth::user()->followers()->where('follower_id',$user->id)->get();
            //$follower = (empty($vFollower[0]) ? null : $vFollower[0]);

            $follower = Auth::user()->followersTable()->where('follower_id',$user->id)->get();
            $follower = (empty($follower[0]) ? null : $follower[0]);

	        $my_perfil = false;

            $categoriasAutorizadas = DB::table('categorias')
                            ->join('follower_categoria', 'categorias.id', '=', 'follower_categoria.categoria_id')
                            ->join('followers', 'followers.id', '=', 'follower_categoria.follower_id')
                            ->select('categorias.*')
                            ->where('followers.follower_id',Auth::user()->id)->get();
            
            
    	}
       
        $vCategoria = categoria::where([
                    ['user_id', $user->id],
                    ['descricao', $categoriaDefault],
        ])->get();
        
        if(empty($vCategoria[0])){           
            $categoriaDefault = "Pessoal";
            $vCategoria = categoria::where([
                    ['user_id', $user->id],
                    ['descricao', $categoriaDefault],
            ])->get();
            
        }
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
        
        if($my_perfil){

            if($user->followers()->count() == 0)
                $people = $user::where('id','<>', Auth::user()->id)->take(5)->get();

            return view('profile', array(
                 'user' => $user, 
                 'categoriaSetada' => $categoriaDefault,
                 'people' => (empty($people) ?  null : $people),
            ));
        }else{            
            $people = User::where('id','<>', Auth::user()->id)->take(5)->get();            
            $categoriaDefault = $categoria;            


            return view('profile_follower', array(
                 'user' => $user, 
                 'categoriaSetada' => $categoriaDefault,
                 'my_perfil' => $my_perfil,
                 'follower' => $follower,
                 'people' => $people,
                 'categoriasAutorizadas' => $categoriasAutorizadas,
            ));

        }
    }
    
    public function follow(Request $request){
        if($request->ajax()){
            $idUser = $request->input('idUser');
            $user = User::find($idUser);

            /*apagará o registo*/
            //$user->roles()->detach($roleId);
            //$user->roles()->detach([1, 2, 3]);
            //$user->roles()->detach(); all

            /*inserir um registo*/
            //$user->roles()->attach($roleId);
            /*inserir um registo + campos*/
            //$user->roles()->attach($roleId, ['expires' => $expires]);

            /*update um registo*/
            //$user->roles()->updateExistingPivot($roleId, $attributes);
            if($user){
                Auth::user()->followers()->attach($user->id);
                echo "1";
            }else{
                echo "0";
            }            
        }
    }

    public function unFollow(Request $request){
        if($request->ajax()){
            $idUser = $request->input('idUser');
            $user = User::find($idUser);            
            if($user){
                Auth::user()->followers()->attach($user->id);
                echo "1";
            }else{
                echo "0";
            }            
        }
    }

    public function favorite(Request $request){
        if($request->ajax()){
            $idUser = $request->input('idUser');
            $user = User::find($idUser);

            if($user){
                $follower = Auth::user()->followersTable()->where('follower_id',$user->id)->get();
                $follower = (empty($follower[0]) ? null : $follower[0]);

                if($follower){
                    Auth::user()->followers()->updateExistingPivot($user->id, ['favorite' => 1]);
                }else{
                    Auth::user()->followers()->attach($user->id, ['favorite' => 1]);
                }            

                echo "1";
            }else{
                echo "0";
            }
        }
    }

    public function unFavorite(Request $request){
        if($request->ajax()){
            $idUser = $request->input('idUser');
            $user = User::find($idUser);

            if($user){
                Auth::user()->followers()->updateExistingPivot($user->id, ['favorite' => 0]);             
            }        
            echo "1";    
        }
    }

    public function permit(Request $request){
        if($request->ajax()){
            $idUser = $request->input('idUser');
            $user = User::find($idUser);

            if($user){
                $follower = Auth::user()->followersTable()->where('follower_id',$user->id)->get();
                $follower = (empty($follower[0]) ? null : $follower[0]);

                if($follower){
                    Auth::user()->followers()->updateExistingPivot($user->id, ['permit' => 1]);
                }else{
                    Auth::user()->followers()->attach($user->id, ['permit' => 1]);
                }            

                echo "1";
            }else{
                echo "0";
            }
        }
    }
    public function unPermit(Request $request){
        if($request->ajax()){
            $idUser = $request->input('idUser');
            $user = User::find($idUser);

            if($user){
                $follower = Auth::user()->followersTable()->where('follower_id',$user->id)->get();
                $follower = (empty($follower[0]) ? null : $follower[0]);

                if($follower){
                    Auth::user()->followers()->updateExistingPivot($user->id, ['permit' => 0]);
                }            
                echo "1";
            }else{
                echo "0";
            }
        }
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

    	if($user->followers()->count() == 0)
            $people = $user::where('id','<>', Auth::user()->id)->take(5)->get();

        return view('profile', array(
             'user' => $user, 
             'categoriaSetada' => "Pessoal",
             'people' => $people,
        ));
    }

     
    
}
