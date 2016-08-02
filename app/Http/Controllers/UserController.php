<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Request;
use App\Http\Requests;
use Carbon\Carbon;
use App\User;
use App\Categoria;
use App\Notification;
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
            $my_perfil = false;            
            $categoriasUserLogado = Auth::user()->categorias()->get();
            $categoriasAutorizadasParaVisitante = null;
        	
            /*Vefificação se eu permiti ao visitante*/
            $follower = Auth::user()->followersTable()->where([
                                                        ['follower_id',$user->id],
                                                        ['user_id',Auth::user()->id],
                                                    ])->get();
            $follower = (empty($follower[0]) ? null : $follower[0]);

	        if($follower){
                $categoriasAutorizadasParaVisitante = DB::table('categorias')
                                ->join('follower_categoria', 'categorias.id', '=', 'follower_categoria.categoria_id')
                                ->join('followers', 'followers.id', '=', 'follower_categoria.follower_id')
                                ->select('categorias.*')
                                ->where('followers.id', $follower->id)->get();
                
                foreach ($categoriasUserLogado as $key => $categoria) {
                    foreach ($categoriasAutorizadasParaVisitante as $key2 => $ca) {
                        if ($ca->id == $categoria->id) {
                            $categoriasUserLogado[$key]['selected'] = true;
                        }
                    }
                }
            }

            /*Vefificação se o visitante me permitiu acesso*/
            $follower2 = $user->followersTable()->where([
                                                        ['follower_id',Auth::user()->id],
                                                        ['user_id',$user->id],
                                                    ])->get();
            
            $follower2 = (empty($follower2[0]) ? null : $follower2[0]);
            $categoriasAutorizadasDoVisitante = null;
            if($follower2){
                $categoriasAutorizadasDoVisitante = DB::table('categorias')
                                ->join('follower_categoria', 'categorias.id', '=', 'follower_categoria.categoria_id')
                                ->join('followers', 'followers.id', '=', 'follower_categoria.follower_id')
                                ->select('categorias.*')
                                ->where('followers.id', $follower2->id)->get();
            }

            
    	}

       $vCategoriasExibir = categoria::where([
                    ['categorias.user_id', $user->id],
                    ['tarefas.privado', 0],
                    ['tarefas.status', 'A'],
                ])->join('tarefas', 'categorias.id', '=', 'tarefas.categoria_id')
                  ->select('categorias.*')
                  ->distinct()->get();                

        foreach ($vCategoriasExibir as $key => $categoria) {
            if($categoria['descricao'] == $categoriaDefault){
                $categoria = $categoria;
            }
        }
        
        if(empty($categoria)){
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
        }else{
            $categoria = $vCategoriasExibir[0];
        }        
        


        $campoOrdenacao = "created_at";
        $order = "asc";
        $tarefasAtivas = Tarefa::where(
                [
                    ['doit', $user->id],
                    ['categoria_id', $categoria->id],
                    ['status', 'A'],
                ]            
            )->orderBy($campoOrdenacao, $order)->get();        

        $user->tarefas = $tarefasAtivas;
        if($my_perfil){
            foreach ($user->tarefas as $key => $t) {               
                $dt = new Carbon($t->created_at, 'America/Maceio');
                $user->tarefas[$key]['tempoCadastada'] = $dt->diffForHumans(Carbon::now('America/Maceio'));         
            
            }
        }else{
            foreach ($user->tarefas as $key => $t) {   
                if($t->privado == 1 && $t->user_id == Auth::user()->id or $t->privado != 1){
                    $dt = new Carbon($t->created_at, 'America/Maceio');
                    $user->tarefas[$key]['tempoCadastada'] = $dt->diffForHumans(Carbon::now('America/Maceio'));         
                }else{
                    unset($user->tarefas[$key]);
                }
            }
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
                 'categoriasExibir' => $vCategoriasExibir,
                 'categoriaSetada' => $categoriaDefault,
                 'my_perfil' => $my_perfil,
                 'follower' => $follower,
                 'people' => $people,
                 'categoriasAutorizadasParaVisitante' => $categoriasAutorizadasParaVisitante,
                 'categoriasAutorizadasDoVisitante' => $categoriasAutorizadasDoVisitante,
                 'categoriasUserLogado' => $categoriasUserLogado,
            ));

        }
    }
    
    public function follow(Request $request){
        if($request->ajax()){
            $idUser = $request->input('idUser');
            $user = User::find($idUser);

            if($user){
                $follower = Auth::user()->followersTable()->where('follower_id',$user->id)->get();
                $follower = (empty($follower[0]) ? null : $follower[0]);

                if($follower){
                    Auth::user()->followers()->updateExistingPivot($user->id, ['follow' => 1]);
                }else{
                    Auth::user()->followers()->attach($user->id, ['follow' => 1]);
                }
                /*Envia notificação*/
                $message = "Está seguindo você!!!";
                $id = Notification::insertGetId(
                        ['user_id' =>  $user->id, 'sender_id' => Auth::user()->id, 'message' => $message, 'status' => 'I', 'created_at' => Carbon::now()]
                        );

                $notification = Notification::find($id);                
                $notification->save();           

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
                $follower = Auth::user()->followersTable()->where('follower_id',$user->id)->get();
                $follower = (empty($follower[0]) ? null : $follower[0]);

                if($follower){
                    Auth::user()->followers()->updateExistingPivot($user->id, ['follow' => 0,  'favorite' => 0]);
                }  
                $this->validaFollower($user->id);       

                /*Envia notificação*/
                $message = "Não está mais seguindo você!!!";
                $id = Notification::insertGetId(
                        ['user_id' =>  $user->id, 'sender_id' => Auth::user()->id, 'message' => $message, 'status' => 'I', 'created_at' => Carbon::now()]
                        );

                $notification = Notification::find($id);                
                $notification->save();  

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
                    Auth::user()->followers()->attach($user->id, ['favorite' => 1, 'follow' => 1]);
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
            $this->validaFollower($user->id);      
            echo "1";    
        }
    }

    public function permit(Request $request){
        if($request->ajax()){

            $opcoes = $request->input('opcoes');
            $vCategorias = json_decode($opcoes,true);
            
            
            $idUser = $request->input('idUser');
            $user = User::find($idUser);

            if($user){
                $follower = Auth::user()->followersTable()->where('follower_id',$user->id)->get();
                $follower = (empty($follower[0]) ? null : $follower[0]);

                if($follower){
                    Auth::user()->followers()->updateExistingPivot($user->id, ['permit' => 1]);
                    $this->addOrRemoveCategoriasPermit($follower->id, $vCategorias);
                    
                }else{
                    Auth::user()->followers()->attach($user->id, ['permit' => 1]);
                    $follower = Auth::user()->followersTable()->where('follower_id',$user->id)->get();
                    
                    $this->addOrRemoveCategoriasPermit($follower[0]->id, $vCategorias);
                }            

                /*Envia notificação*/
                $message = "Permitiu a você escrever nas tarefas dele!!!";
                $id = Notification::insertGetId(
                        ['user_id' =>  $user->id, 'sender_id' => Auth::user()->id, 'message' => $message, 'status' => 'I', 'created_at' => Carbon::now()]
                        );

                $notification = Notification::find($id);                
                $notification->save();

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
                    DB::table('follower_categoria')->where('follower_id', $follower->id)->delete();
                }    
                $this->validaFollower($user->id);        
                echo "1";
            }else{
                echo "0";
            }
        }
    }

    private function validaFollower($id){
        $follower = Auth::user()->followersTable()->where('follower_id',$id)->get();
        $follower = (empty($follower[0]) ? null : $follower[0]);

        if($follower){
            if (!$follower->permit && !$follower->favorite && !$follower->follow) {
                DB::table('followers')->where('id', $follower->id)->delete();
                DB::table('follower_categoria')->where('follower_id', $follower->id)->delete(); 
            }            
        }  

    }
    private function addOrRemoveCategoriasPermit($follower_id, $categorias){        
        
        DB::table('follower_categoria')->where('follower_id', $follower_id)->delete(); 
        if(!empty($categorias)){            
            foreach ($categorias as $key => $categoria) {
                DB::table('follower_categoria')->insert([
                    ['follower_id' => $follower_id, 'categoria_id' => $categoria['categoria_id']],
                ]);   
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
