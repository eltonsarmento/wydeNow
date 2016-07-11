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

    	$texto    = $request->input('texto');

    	
    	$palavra  = "#privado";
    	$pos      = strripos($texto,$palavra);    	
		if ($pos === false) {
		    $privado = 0;
		} else {
		    $privado = 1;
		    $texto = str_replace($palavra,"",$texto);
		}
		
		$tarefa = new Tarefa();
		$tarefa->texto = $texto;
		$tarefa->privado = $privado;
    	$tarefa->user_id = Auth::user()->id;  

    	$tarefa->save();
        
        return redirect('/profile');
    }
}
