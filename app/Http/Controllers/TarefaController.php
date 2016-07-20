<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Request;
use App\Http\Requests;
use App\Tarefa;
use App\User;
use App\Categoria;
use Carbon\Carbon;
use Auth;


class TarefaController extends Controller {

    public function __construct(){
        $this->middleware('auth');
    }

    public function index($categoriaDefault = "Pessoal"){        
        $user = Auth::user();             
       

        $vCategoria = categoria::where(
                [
                    ['user_id', $user->id],
                    ['descricao', $categoriaDefault],
                ]            
            )->get();
        $categoria = $vCategoria[0];
        
        if($categoria->prioridade == "data"){
            $campoOrdenacao = "created_at";
            $order = "asc";
            $opçãoEscolhida = "Data de Cadastro";
        }elseif($categoria->prioridade == "dataDesc"){
            $campoOrdenacao = "created_at";
            $order = "desc";
            $opçãoEscolhida = "Data de Cadastro invertida";
        }else{
            $order = "asc";            
            $campoOrdenacao = "posicao";
            $opçãoEscolhida = "Prioridade";
        }

        $tarefasAtivas = Tarefa::where(
                [
                    ['user_id', $user->id],
                    ['categoria_id', $categoria->id],
                    ['status', 'A'],
                ]            
            )->orderBy($campoOrdenacao, $order)->get();        

        $tarefasConcluidas = Tarefa::where(
                [
                    ['user_id', $user->id],
                    ['categoria_id', $categoria->id],
                    ['status', 'C'],
                    ['data_conclusao', '>=', Carbon::today()],
                    ['data_conclusao', '<', Carbon::tomorrow()],
                ]            
            )->orderBy($campoOrdenacao, $order)->get();        


        //print_r($tarefasConcluidas);
        $user->tarefas = $tarefasAtivas;
        foreach ($user->tarefas as $key => $t) {
            $dt = new Carbon($t->created_at, 'America/Maceio');
            $user->tarefas[$key]['tempoCadastada'] = $dt->diffForHumans(Carbon::now('America/Maceio'));         
        }
        $user->tarefasConcluidas = $tarefasConcluidas;
        foreach ($user->tarefasConcluidas as $key => $t) {
            $dt = new Carbon($t->created_at, 'America/Maceio');
            $user->tarefasConcluidas[$key]['tempoCadastada'] = $dt->diffForHumans(Carbon::now('America/Maceio'));         
        }        

        if($user->followers()->count() == 0)
            $people = User::where('id','<>', $user->id)->take(5)->get();
        
        
        return view('tarefas', array(
                 'user' => $user, 
                 'categoriaSetada' => $categoriaDefault, 
                 "opçãoEscolhida" => $opçãoEscolhida,
                 "people" => $people,
        ));
    }

    public function adiciona(){

        $categoria_id = Request::input('categoria_id');
        $tarefa = Tarefa::select('posicao')->where(
            [
                ['categoria_id', $categoria_id],
                ['user_id', Auth::user()->id],
                ['status', 'A'],
            ]
        )->orderBy('posicao', "desc")->get();  

        $posicao = (empty($tarefa[0]) ? 1 : $tarefa[0]->posicao + 1);

    	$texto    = Request::input('texto');        

    	/*Valida */
    	$palavra  = "#privado";
    	$pos      = strripos($texto,$palavra);    	
		if ($pos === false) {
		    $privado = 0;
		} else {
		    $privado = 1;
		    $texto = str_replace($palavra,"",$texto);
		}
		


        /*Constroi e salva */
		$tarefa               = new Tarefa();
		$tarefa->texto        = $texto;
		$tarefa->privado      = $privado;
        $tarefa->posicao      = $posicao;
        $tarefa->categoria_id = $categoria_id;
        $tarefa->status       = "A";
    	$tarefa->user_id      = Auth::user()->id;  
    	$tarefa->save();

        $categoria = Categoria::find($categoria_id);
        
        return redirect('/tarefa/'.$categoria->descricao);
    }

    public function concluir(){

        if(Request::ajax()){
            $id = Request::input('id');
            $tarefa = Tarefa::find($id);            
            $tarefa->status = "C";
            $tarefa->data_conclusao = Carbon::now();
            $tarefa->save();
            
            $tarefasAtivas     = Tarefa::where([
                                        ['status', 'A'],
                                        ['categoria_id', $tarefa->categoria_id],
                                        ['user_id', $tarefa->user_id]
                                ])->orderBy('posicao', "asc")->get();  
            $tarefasConcluidas = Tarefa::where([
                                        ['status', 'C'],
                                        ['categoria_id', $tarefa->categoria_id],
                                        ['user_id', $tarefa->user_id]
                                ])->get();

            foreach ($tarefasAtivas as $key => $ta) {
                $dt = new Carbon($ta->created_at, 'America/Maceio');                
                $arrayAtivas[] = ['id' => $ta->id, 'texto' => $ta->texto, 'status' => $ta->status, "privado" => $ta->privado ,"tempoCadastada" => $dt->diffForHumans(Carbon::now('America/Maceio'))];         
            }
            $jsonAtivas = array('tarefasAtivas' => $arrayAtivas);


            foreach ($tarefasConcluidas as $key => $tc) {
                $dt = new Carbon($tc->created_at, 'America/Maceio');                

                $arrayConcluidas[] = ['id' => $tc->id, 'texto' => $tc->texto , 'status' => $tc->status, "privado" => $tc->privado, "tempoCadastada" => $dt->diffForHumans(Carbon::now('America/Maceio'))];         
            }
            $jsonConcluidas = array('tarefasConcluidas' => $arrayConcluidas);

            $json = array_merge($jsonAtivas, $jsonConcluidas);
            
            
            echo json_encode($json);die();           
        }
        
    }

    public function remover(){

        if(Request::ajax()){
            $id = Request::input('id');
            $tarefa = Tarefa::find($id);            
            $tarefa->status = "E";            
            $tarefa->save();
            
            $tarefasAtivas     = Tarefa::where([
                                        ['status', 'A'],
                                        ['categoria_id', $tarefa->categoria_id],
                                        ['user_id', $tarefa->user_id]
                                ])->orderBy('posicao', "asc")->get();  
            $tarefasConcluidas = Tarefa::where([
                                        ['status', 'C'],
                                        ['categoria_id', $tarefa->categoria_id],
                                        ['user_id', $tarefa->user_id]
                                ])->get();

            foreach ($tarefasAtivas as $key => $ta) {
                $dt = new Carbon($ta->created_at, 'America/Maceio');                
                $arrayAtivas[] = ['id' => $ta->id, 'texto' => $ta->texto, 'status' => $ta->status, "privado" => $ta->privado ,"tempoCadastada" => $dt->diffForHumans(Carbon::now('America/Maceio'))];         
            }
            $jsonAtivas = array('tarefasAtivas' => $arrayAtivas);


            foreach ($tarefasConcluidas as $key => $tc) {
                $dt = new Carbon($tc->created_at, 'America/Maceio');                

                $arrayConcluidas[] = ['id' => $tc->id, 'texto' => $tc->texto , 'status' => $tc->status, "privado" => $tc->privado, "tempoCadastada" => $dt->diffForHumans(Carbon::now('America/Maceio'))];         
            }
            $jsonConcluidas = array('tarefasConcluidas' => $arrayConcluidas);

            $json = array_merge($jsonAtivas, $jsonConcluidas);
                        
            echo json_encode($json);die();           
        }
        
    }

    public function ordenar($categoria_id, $tipo){
       
        $vCategoria = categoria::where(
                [
                    ['user_id', Auth::user()->id],
                    ['id', $categoria_id],
                ]            
            )->get();
        $categoria = $vCategoria[0];
        $categoria->prioridade = $tipo;
        $categoria->save();


        return redirect('/tarefa/'.$categoria->descricao);        

    }

    public function ordenarPrioridade($categoria_id){

        $vCategoria = categoria::where(
                [
                    ['user_id', Auth::user()->id],
                    ['id', $categoria_id],
                ]            
            )->get();
        $categoria = $vCategoria[0];
        $categoria->prioridade = "Prioridade";
        $categoria->save();

        if(Request::ajax()){
            $post = Request::input('json');
            $json = json_decode($post,true);

            $tarefas = Tarefa::where(
                [
                    ['user_id', Auth::user()->id],
                    ['categoria_id', $categoria_id],
                ]            
            )->get();     

            foreach ($json as $key => $item) {
                foreach ($tarefas as $key => $tarefa) {
                    //echo "<br> id: ".$item['id'] . " == ".$tarefa->id;
                    if($item['id'] == $tarefa->id){
                        //echo "<br> sim. atualiza de ".$tarefa->posicao . " para ".$item['ordem'];
                        $tarefa->posicao = $item['ordem'];
                        $tarefa->save();
                    }
                }
            }
            return redirect('/tarefa/'.$categoria->descricao);die();
        }
        return redirect('/tarefa/');die();
    }

    

    public function add_categoria(){

        if(Request::has('categoria')){
            $descricao = Request::input('categoria');

            $categoria = new Categoria;
            $categoria->user_id = Auth::user()->id;            
            $categoria->descricao = $descricao;
            $categoria->save();
        }
        
        return redirect('/tarefa');
    }
}
