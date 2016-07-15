<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Request;
use App\Http\Requests;
use App\Tarefa;
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
                    ['user_id', Auth::user()->id],
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
        $tarefas = Tarefa::where(
                [
                    ['user_id', Auth::user()->id],
                    ['categoria_id', $categoria->id],
                ]            
            )->orderBy($campoOrdenacao, $order)->get();        

        $user->tarefas = $tarefas;
        foreach ($user->tarefas as $key => $t) {
            $dt = new Carbon($t->created_at, 'America/Maceio');
            $user->tarefas[$key]['tempoCadastada'] = $dt->diffForHumans(Carbon::now('America/Maceio'));         
        }
        
        return view('tarefas', array('user' => $user, 'categoriaSetada' => $categoriaDefault, "opçãoEscolhida" => $opçãoEscolhida));
    }

    public function adiciona(Request $request){

        $categoria_id = $request->input('categoria_id');
        $tarefa = Tarefa::select('posicao')->where(
            [
                ['categoria_id', $categoria_id],
                ['user_id', Auth::user()->id],
            ]
        )->get();

        $posicao = (empty($tarefa[0]) ? 1 : $tarefa[0]->posicao + 1);

    	$texto    = $request->input('texto');

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
        
        return redirect('/tarefa');
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

    public function concluir($categoria_id){

        if(Request::ajax()){
            $id = Request::input('id');
            print_r($id);die();

            $tarefa = Tarefa::find($id);
            $tarefa->status = "C";
            $tarefa->save();

            return redirect('/tarefa/'.$categoria->descricao);die();
        }
        return redirect('/tarefa/');die();
    }


    public function add_categoria(Request $request){

        if($request->has('categoria')){
            $texto = $request->input('categoria');

            $categoria = new Categoria;
            $categoria->user_id = Auth::user()->id;            
            $categoria->texto = $texto;
            //$categoria->save();
        }
        
        return redirect('/tarefa');
    }
}
