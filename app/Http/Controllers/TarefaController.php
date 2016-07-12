<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Tarefa;
use Auth;


class TarefaController extends Controller {

    public function __construct(){
        $this->middleware('auth');
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
        
        return redirect('/profile');
    }
}
