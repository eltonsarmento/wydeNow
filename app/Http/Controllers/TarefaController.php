<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Request;
use App\Http\Requests;
use App\Tarefa;
use App\Notification;
use App\User;
use App\Categoria;
use App\Suggestion;
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
            $opcaoEscolhida = "Data de Cadastro";
        }elseif($categoria->prioridade == "dataDesc"){
            $campoOrdenacao = "created_at";
            $order = "desc";
            $opcaoEscolhida = "Data de Cadastro invertida";
        }else{
            $order = "asc";            
            $campoOrdenacao = "posicao";
            $opcaoEscolhida = "Prioridade";
        }

        $tarefasAtivas = Tarefa::where(
                [
                    ['doit', $user->id],
                    ['categoria_id', $categoria->id],
                    ['status', 'A'],
                ]            
        )->orderBy($campoOrdenacao, $order)->get();   

        
               
        foreach ($tarefasAtivas as $key => $t) {        
            if($t->user_id != Auth::user()->id){
                $tarefasAtivas[$key]['isdoit'] = true;
                $userDoIT = User::find($t->user_id);
                $tarefasAtivas[$key]['userDoIt'] = $userDoIT;
            }
        }        
        
        $tarefasConcluidas = Tarefa::where(
            [
                ['tarefas.status', 'C'],
                ['categoria_id', $categoria->id],
                ['doit', $user->id],
                ['data_conclusao', '>=', Carbon::today()],
                ['data_conclusao', '<', Carbon::tomorrow()],
            ]
        )->leftjoin('suggestions', 'suggestions.tarefa_id', '=', 'tarefas.id')
        ->select('tarefas.*', 'suggestions.id as id_suggestion')
        ->orderBy($campoOrdenacao, $order)->get();

        $user->tarefasDoIT = Tarefa::where(
                [
                    ['user_id', Auth::user()->id],
                    ['doit', '<>' ,Auth::user()->id],                                        
                ]            
        )->whereIn('status', ['A','R'])->get();

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
                 "opcaoEscolhida" => $opcaoEscolhida,
                 "people" => (empty($people) ? null : $people),
        ));
    }

    public function indexDoit(){             
        $user = Auth::user();             
          
        $user->tarefas = Tarefa::where(
                [
                    ['user_id', Auth::user()->id],
                    ['doit', '<>' ,Auth::user()->id],                              
                ]            
        )->whereIn('status', ['A','R'])
        ->join('users', 'users.id', '=', 'tarefas.doit')
        ->orderBy('nickname')
        ->select('tarefas.*', 'users.name', 'users.nickname','users.avatar')->get();
        
        $user->tarefasConcluidas = Tarefa::where(
                [
                    ['user_id', Auth::user()->id],
                    ['doit', '<>' ,Auth::user()->id],
                    ['status', 'C'],
                    ['data_conclusao', '>=', Carbon::today()],
                    ['data_conclusao', '<', Carbon::tomorrow()],
                ]            
        )->join('users', 'users.id', '=', 'tarefas.doit')
        ->orderBy('nickname')
        ->select('tarefas.*', 'users.name', 'users.nickname','users.avatar')->get();   

        
        
        foreach ($user->tarefas as $key => $t) {
            $dt = new Carbon($t->created_at, 'America/Maceio');
            $user->tarefas[$key]['tempoCadastada'] = $dt->diffForHumans(Carbon::now('America/Maceio'));         
        }

        foreach ($user->tarefasConcluidas as $key => $t) {
            $dt = new Carbon($t->created_at, 'America/Maceio');
            $user->tarefasConcluidas[$key]['tempoCadastada'] = $dt->diffForHumans(Carbon::now('America/Maceio'));         
        }        


        if($user->followers()->count() == 0)
            $people = User::where('id','<>', $user->id)->take(5)->get();
        
        
        return view('tarefas_doit', array(
                 'user' => $user,                                   
                 "people" => (empty($people) ? null : $people),
        ));
    }

    public function listByStatus($tipo = "Ativas"){

        if($tipo == "ativas"){
            $opcao = 'Aguardando';
            $status = 'A';
        }else if($tipo == "concluidas"){
            $opcao = 'Concluídas';
            $status = 'C';
        }
        
        $user = Auth::user();

        $tarefas = Tarefa::where(
            [
                ['tarefas.doit', Auth::user()->id],
                ['tarefas.status', $status],
            ]            
        )->leftjoin('suggestions', 'suggestions.tarefa_id', '=', 'tarefas.id')
         ->select('tarefas.*', 'suggestions.id as id_suggestion')
         ->orderBy('created_at', 'asc')->get(); 


        foreach ($tarefas as $key => $t) {        
            if($t->user_id != Auth::user()->id){
                $tarefas[$key]['isdoit'] = true;
                $userDoIT = User::find($t->user_id);
                $tarefas[$key]['userDoIt'] = $userDoIT;
            }            
        }
        $user->tarefas = $tarefas;
        foreach ($user->tarefas as $key => $t) {
            $dt = new Carbon($t->created_at, 'America/Maceio');
            $user->tarefas[$key]['tempoCadastada'] = $dt->diffForHumans(Carbon::now('America/Maceio'));         
        }        


        if($user->followers()->count() == 0)
            $people = User::where('id','<>', $user->id)->take(5)->get();
        
        
        return view('tarefas_by_filter', array(
                 'user' => $user,                                           
                 'opcao' => $opcao,
                 "people" => (empty($people) ? null : $people),
        ));
    }

    public function adiciona(){

        if(Request::ajax()){
            $categoria_id = Request::input('categoria_id');
            $texto        = Request::input('texto');  

            /*Valida */
            $palavra  = "#privado";
            $pos      = strripos($texto,$palavra);      
            if ($pos === false) {
                $privado = 0;
            } else {
                $privado = 1;
                $texto = str_replace($palavra,"",$texto);
            }

            $tarefa = Tarefa::select('posicao')->where([
                    ['categoria_id', $categoria_id],
                    ['user_id', Auth::user()->id],
                    ['status', 'A'],
            ])->orderBy('posicao', "desc")->get();  

            $posicao = (empty($tarefa[0]) ? 1 : $tarefa[0]->posicao + 1);

            /*Constroi e salva */
            $tarefa               = new Tarefa();
            $tarefa->texto        = $texto;
            $tarefa->privado      = $privado;
            $tarefa->posicao      = $posicao;
            $tarefa->categoria_id = $categoria_id;
            $tarefa->status       = "A";
            $tarefa->user_id      = Auth::user()->id;  
            $tarefa->doit         = Auth::user()->id;  
            $tarefa->save();
            
        }else{
            $categoria_id = Request::input('categoria_id');
            $texto    = Request::input('texto');   

            $tarefa = Tarefa::select('posicao')->where(
                [
                    ['categoria_id', $categoria_id],
                    ['user_id', Auth::user()->id],
                    ['status', 'A'],
                ]
            )->orderBy('posicao', "desc")->get();  

            $posicao = (empty($tarefa[0]) ? 1 : $tarefa[0]->posicao + 1);

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
            $tarefa->doit         = Auth::user()->id;  
            $tarefa->save();

            $categoria = Categoria::find($categoria_id);

            
            return redirect('/tarefa/'.$categoria->descricao);
        }
    }


    public function doit(){

        $categoria_id = Request::input('categoria_id');
        $user_id      = Request::input('user_id');
        $user         = User::find($user_id);
        $tarefa = Tarefa::select('posicao')->where(
            [
                ['categoria_id', $categoria_id],
                ['user_id', $user->id],
                ['status', 'A'],
            ]
        )->orderBy('posicao', "desc")->get();  

        $posicao = (empty($tarefa[0]) ? 1 : $tarefa[0]->posicao + 1);

        /*Constroi e salva */
        $tarefa               = new Tarefa();
        $tarefa->texto        = Request::input('texto');
        $tarefa->privado      = 1;
        $tarefa->posicao      = $posicao;
        $tarefa->categoria_id = $categoria_id;
        $tarefa->status       = "A";
        $tarefa->user_id      = Auth::user()->id;  
        $tarefa->doit         = $user_id;  
        $tarefa->save();

        $categoria = Categoria::find($categoria_id);
        
        
        $id = Notification::insertGetId(
                    ['user_id' => $user_id, 'sender_id' => Auth::user()->id, 'message' => "Enviou uma tarefa DoIt para você!", 'status' => 'I', 'created_at' => Carbon::now()]
                    );

        $notification = Notification::find($id);
        $notification->link= "redirectFor('/tarefa/".$categoria->descricao."'); return false;";
        $notification->save();

        return redirect('/profile/'.$user->nickname.'/'.$categoria->descricao);
    }

    public function adiciona_sugestao(){

        if(Request::ajax()){
            $suggestoin            = new Suggestion();
            $suggestoin->texto     = Request::input('texto');        
            $suggestoin->tarefa_id = Request::input('tarefa_id');        
            $suggestoin->user_id   = Auth::user()->id;
            $suggestoin->status    = "A";
            $suggestoin->save();  

            $suggestions = Suggestion::where('suggestions.tarefa_id', $suggestoin->tarefa_id)
                                ->join('users', 'users.id', '=', 'suggestions.user_id')
                                ->join('tarefas', 'tarefas.id', '=', 'suggestions.tarefa_id')
                                ->join('users as owner', 'owner.id', '=', 'tarefas.doit')                            
                                ->select('suggestions.*', 'tarefas.texto as textoTarefa','users.name', 'users.nickname','users.avatar', 'owner.id as owner')
                                ->orderBy('suggestions.created_at', 'asc')->get();

            $json = [];
            if($suggestions->count() > 0){
                foreach ($suggestions as $key => $s) {
                    $textoTarefa = $s->textoTarefa;
                    $owner = false;
                    if($s->owner == $s->user_id){
                        $owner = true;
                    }
                    
                    $dt = new Carbon($s->created_at, 'America/Maceio');                                
                    $diference = Carbon::today()->diffInHours($dt, false);       
                    if($diference > 1 && $diference <= 23)
                        $dataFormat = $dt->format('h:i A');
                    else
                        $dataFormat = $dt->format('d/m/Y h:i A');;            
                    
                    $json[] = ['id' => $s->id, 'isOwner' => $owner, 'texto' => $s->texto, "data" => $dataFormat , 'id_usuario' => $s->user_id, 'avatar' => $s->avatar, 'name' => $s->name, 'nickname' => $s->nickname];
                }
            }

            if(Auth::user()->id != $s->owner){
                $message = "Escreveu uma sugestão na tarefa: <strong>".$textoTarefa."</strong>";
                $id = Notification::insertGetId(
                        ['user_id' =>  $s->owner, 'sender_id' => Auth::user()->id, 'message' => $message, 'status' => 'I', 'created_at' => Carbon::now()]
                        );

                $notification = Notification::find($id);
                $notification->link= "setaDadosModalSugestaoNotification('".$suggestoin->tarefa_id."','".$textoTarefa."', '".$id."'); return false;";
                $notification->save();
            }
            echo json_encode($json);die();         
        }
    }

    public function getSuggestion(){

        if(Request::ajax()){
            $tarefa_id = Request::input('tarefa_id');
            $tarefa = Tarefa::find($tarefa_id);
            $suggestions = Suggestion::where('suggestions.tarefa_id', $tarefa->id)
                                ->join('users', 'users.id', '=', 'suggestions.user_id')
                                ->join('tarefas', 'tarefas.id', '=', 'suggestions.tarefa_id')
                                ->join('users as owner', 'owner.id', '=', 'tarefas.doit')                            
                                ->select('suggestions.*', 'users.name', 'users.nickname','users.avatar', 'owner.id as owner')
                                ->orderBy('suggestions.created_at', 'asc')->get(); 

            $json = [];
            if($suggestions->count() > 0){
                foreach ($suggestions as $key => $s) {
                    $owner = false;
                    if($s->owner == $s->user_id){
                        $owner = true;
                    }
                    $dt = new Carbon($s->created_at, 'America/Maceio');                   
                    $diference = Carbon::today()->diffInHours($dt, false);       
                    if($diference > 1 && $diference <= 23){
                        $dataFormat = $dt->format('h:i A');            
                    }else{
                        $dataFormat = $dt->format('d/m/Y h:i A');;            
                    }
                    $json[] = ['id' => $s->id, 'statusTarefa' => $tarefa->status, 'isOwner' => $owner, 'texto' => $s->texto, "data" => $dataFormat, 'id_usuario' => $s->user_id, 'avatar' => $s->avatar, 'name' => $s->name, 'nickname' => $s->nickname];
                }
            }

            echo json_encode($json);die();
        } 
    }


    public function getMyCategories(){

        $categorias = Categoria::where('user_id', Auth::user()->id)->get();
       
        
        foreach ($categorias as $key => $c) {
            $json[] = ['id' => $c->id, 'descricao' => $c->descricao,];
        }


        echo json_encode($json);die();
    }

    public function concluir(){

        if(Request::ajax()){
            $id = Request::input('id');
            $tarefa = Tarefa::find($id);            
            $tarefa->status = "C";
            $tarefa->data_conclusao = Carbon::now();
            $tarefa->save();
            
            if($tarefa->user_id != $tarefa->doit){
                /*Envia notificação*/
                $message = "Concluiu a tarefa doit: <strong>".$tarefa->texto."</strong>";
                $id = Notification::insertGetId(
                        ['user_id' =>  $tarefa->user_id, 'sender_id' => $tarefa->doit, 'message' => $message, 'status' => 'I', 'created_at' => Carbon::now()]
                        );

                $notification = Notification::find($id);                
                $notification->link= "redirectFor('/tarefa/doit/".$userNoti->nickname."'); return false;";
                $notification->save();
            }

            $tipoOrdenacao = $this->getCategoriaParaOrdenacao($tarefa->categoria_id);

            

            $json = [];
            $jsonAtivas = "";
            $tarefasAtivas = Tarefa::where(
                    [
                        ['doit', Auth::user()->id],
                        ['categoria_id', $tarefa->categoria_id],
                        ['status', 'A'],
                    ]            
            )->orderBy($tipoOrdenacao['prioridade'], $tipoOrdenacao['ordem'])->distinct()->get();             

            if($tarefasAtivas->count() > 0){
                foreach ($tarefasAtivas as $key => $t) {  
                    if($t->user_id != Auth::user()->id){
                        $tarefasAtivas[$key]['isdoit'] = true;
                        $userDoIT = User::find($t->user_id);
                        $tarefasAtivas[$key]['avatar'] = $userDoIT->avatar;
                        $tarefasAtivas[$key]['name'] = $userDoIT->name;
                        $tarefasAtivas[$key]['nickname'] = $userDoIT->nickname;
                    }else{
                        $tarefasAtivas[$key]['isdoit'] = false;
                    }
                }

                foreach ($tarefasAtivas as $key => $ta) {
                    $dt = new Carbon($ta->created_at, 'America/Maceio');                                
                    $arrayAtivas[] = ['id' => $ta->id, 'isdoit' => $ta->isdoit, 'texto' => $ta->texto, 'status' => $ta->status, "privado" => $ta->privado ,"tempoCadastada" => $dt->diffForHumans(Carbon::now('America/Maceio')), 'avatar' => $t->avatar, 'name' => $t->name, 'nickname' => $t->nickname];         
                }
                $jsonAtivas = array('tarefasAtivas' => $arrayAtivas);

                $json = $jsonAtivas;
            }
            $tarefasConcluidas = Tarefa::where([
                                        ['tarefas.status', 'C'],
                                        ['categoria_id', $tarefa->categoria_id],
                                        ['doit', Auth::user()->id],
                                        ['data_conclusao', '>=', Carbon::today()],
                                        ['data_conclusao', '<', Carbon::tomorrow()],
                                ])->leftjoin('suggestions', 'suggestions.tarefa_id', '=', 'tarefas.id')
                                  ->select('tarefas.*', 'suggestions.id as id_suggestion')
                                  ->orderBy('created_at', "asc")->get(); 

            
            if($tarefasConcluidas->count() > 0){
                foreach ($tarefasConcluidas as $key => $t) {    

                    if($t->id_suggestion)
                        $tarefasConcluidas[$key]['hasSuggestion'] = true;
                    else
                        $tarefasConcluidas[$key]['hasSuggestion'] = false;

                    if($t->user_id != Auth::user()->id){
                        $tarefasConcluidas[$key]['isdoit'] = true;
                        $userDoIT = User::find($t->user_id);
                        $tarefasConcluidas[$key]['avatar'] = $userDoIT->avatar;
                        $tarefasConcluidas[$key]['name'] = $userDoIT->name;
                        $tarefasConcluidas[$key]['nickname'] = $userDoIT->nickname;
                    }else{
                        $tarefasConcluidas[$key]['isdoit'] = false;
                    }
                }                
                foreach ($tarefasConcluidas as $key => $tc) {
                    $dt = new Carbon($tc->created_at, 'America/Maceio');                
                    $arrayConcluidas[] = ['id' => $tc->id, 'hasSuggestion' => $tc->hasSuggestion, 'isdoit' => $tc->isdoit, 'texto' => addslashes($tc->texto) , 'status' => $tc->status, "privado" => $tc->privado, "tempoCadastada" => $dt->diffForHumans(Carbon::now('America/Maceio')) , 'avatar' => $tc->avatar, 'name' => $tc->name, 'nickname' => $tc->nickname];                 
                }
                $jsonConcluidas = array('tarefasConcluidas' => $arrayConcluidas);

                if($jsonAtivas)
                    $json = array_merge($jsonAtivas, $jsonConcluidas);
                else
                    $json = $jsonConcluidas;
            }
            echo json_encode($json);die();           
        }
        
    }

    public function concluirByFilter(){

        if(Request::ajax()){
            $id = Request::input('id');
            $tarefa = Tarefa::find($id);            
            $tarefa->status = "C";
            $tarefa->data_conclusao = Carbon::now();
            $tarefa->save();
            
            $tipoOrdenacao = $this->getCategoriaParaOrdenacao($tarefa->categoria_id);
            

            $json = [];
            $tarefasAtivas = Tarefa::where(
                    [
                        ['doit', Auth::user()->id],
                        ['status', 'A'],
                    ]            
            )->orderBy($tipoOrdenacao['prioridade'], $tipoOrdenacao['ordem'])->distinct()->get();    

            

            if($tarefasAtivas->count() > 0){
                foreach ($tarefasAtivas as $key => $t) {  
                    if($t->user_id != Auth::user()->id){
                        $tarefasAtivas[$key]['isdoit'] = true;
                        $userDoIT = User::find($t->user_id);
                        $tarefasAtivas[$key]['avatar'] = $userDoIT->avatar;
                        $tarefasAtivas[$key]['name'] = $userDoIT->name;
                        $tarefasAtivas[$key]['nickname'] = $userDoIT->nickname;
                    }else{
                        $tarefasAtivas[$key]['isdoit'] = false;
                    }
                }

                foreach ($tarefasAtivas as $key => $ta) {
                    $dt = new Carbon($ta->created_at, 'America/Maceio');                                
                    $arrayAtivas[] = ['id' => $ta->id, 'isdoit' => $ta->isdoit, 'texto' => $ta->texto, 'status' => $ta->status, "privado" => $ta->privado ,"tempoCadastada" => $dt->diffForHumans(Carbon::now('America/Maceio')), 'avatar' => $t->avatar, 'name' => $t->name, 'nickname' => $t->nickname];         
                }
                $jsonAtivas = array('tarefasAtivas' => $arrayAtivas);

                $json = $jsonAtivas;
            }
            
            echo json_encode($json);die();           
        }
        
    }

    public function remover(){

        if(Request::ajax()){
            $id = Request::input('id');
            $tarefa = Tarefa::find($id);            
            $tarefa->status = "E";            
            $tarefa->save();
            
            $tipoOrdenacao = $this->getCategoriaParaOrdenacao($tarefa->categoria_id);
            
            $json = [];
            $jsonAtivas = "";

            $tarefasAtivas = Tarefa::where(
                    [
                        ['doit', Auth::user()->id],
                        ['categoria_id', $tarefa->categoria_id],
                        ['status', 'A'],
                    ]            
            )->orderBy($tipoOrdenacao['prioridade'], $tipoOrdenacao['ordem'])->distinct()->get();     

            $tarefasConcluidas = Tarefa::where([
                                        ['tarefas.status', 'C'],
                                        ['categoria_id', $tarefa->categoria_id],
                                        ['doit', Auth::user()->id],
                                        ['data_conclusao', '>=', Carbon::today()],
                                        ['data_conclusao', '<', Carbon::tomorrow()],
                                ])->leftjoin('suggestions', 'suggestions.tarefa_id', '=', 'tarefas.id')
                                  ->select('tarefas.*', 'suggestions.id as id_suggestion')
                                  ->orderBy('created_at', "asc")->get(); 

            if($tarefasAtivas->count() > 0){
                foreach ($tarefasAtivas as $key => $t) {  
                    if($t->user_id != Auth::user()->id){
                        $tarefasAtivas[$key]['isdoit'] = true;
                        $userDoIT = User::find($t->user_id);
                        $tarefasAtivas[$key]['avatar'] = $userDoIT->avatar;
                        $tarefasAtivas[$key]['name'] = $userDoIT->name;
                        $tarefasAtivas[$key]['nickname'] = $userDoIT->nickname;
                    }else{
                        $tarefasAtivas[$key]['isdoit'] = false;
                    }
                }

                foreach ($tarefasAtivas as $key => $ta) {
                    $dt = new Carbon($ta->created_at, 'America/Maceio');                                
                    $arrayAtivas[] = ['id' => $ta->id, 'isdoit' => $ta->isdoit, 'texto' => $ta->texto, 'status' => $ta->status, "privado" => $ta->privado ,"tempoCadastada" => $dt->diffForHumans(Carbon::now('America/Maceio')), 'avatar' => $t->avatar, 'name' => $t->name, 'nickname' => $t->nickname];         
                }
                $jsonAtivas = array('tarefasAtivas' => $arrayAtivas);

                $json = $jsonAtivas;
            }

            if($tarefasConcluidas->count() > 0){
                foreach ($tarefasConcluidas as $key => $t) {    

                    if($t->id_suggestion)
                        $tarefasConcluidas[$key]['hasSuggestion'] = true;
                    else
                        $tarefasConcluidas[$key]['hasSuggestion'] = false;

                    if($t->user_id != Auth::user()->id){
                        $tarefasConcluidas[$key]['isdoit'] = true;
                        $userDoIT = User::find($t->user_id);
                        $tarefasConcluidas[$key]['avatar'] = $userDoIT->avatar;
                        $tarefasConcluidas[$key]['name'] = $userDoIT->name;
                        $tarefasConcluidas[$key]['nickname'] = $userDoIT->nickname;
                    }else{
                        $tarefasConcluidas[$key]['isdoit'] = false;
                    }
                }                
                foreach ($tarefasConcluidas as $key => $tc) {
                    $dt = new Carbon($tc->created_at, 'America/Maceio');                
                    $arrayConcluidas[] = ['id' => $tc->id, 'hasSuggestion' => $tc->hasSuggestion, 'isdoit' => $tc->isdoit, 'texto' => addslashes($tc->texto) , 'status' => $tc->status, "privado" => $tc->privado, "tempoCadastada" => $dt->diffForHumans(Carbon::now('America/Maceio')) , 'avatar' => $tc->avatar, 'name' => $tc->name, 'nickname' => $tc->nickname];                 
                }
                $jsonConcluidas = array('tarefasConcluidas' => $arrayConcluidas);

                if($jsonAtivas)
                    $json = array_merge($jsonAtivas, $jsonConcluidas);
                else
                    $json = $jsonConcluidas;
            }
 
            echo json_encode($json);die();           
        }
        
    }

    public function removerDoIt(){

        if(Request::ajax()){
            $id = Request::input('id');
            $tarefa = Tarefa::find($id);            
            $tarefa->status = "E";            
            $tarefa->save();            

            $tipoOrdenacao = $this->getCategoriaParaOrdenacao($tarefa->categoria_id);
            
            $json = [];
            $jsonAtivas = ""; 
            
            $tarefas = Tarefa::where(
                    [
                        ['user_id', Auth::user()->id],
                        ['doit', '<>' ,Auth::user()->id],                              
                    ]            
            )->whereIn('tarefas.status', ['A','R'])
            ->join('users', 'users.id', '=', 'tarefas.doit')
            ->orderBy('nickname')
            ->select('tarefas.*', 'users.name', 'users.nickname','users.avatar')->get();

            $tarefasConcluidas = Tarefa::where(
                    [
                        ['tarefas.user_id', Auth::user()->id],
                        ['tarefas.doit', '<>' ,Auth::user()->id],
                        ['tarefas.status', 'C'],
                        ['tarefas.data_conclusao', '>=', Carbon::today()],
                        ['tarefas.data_conclusao', '<', Carbon::tomorrow()],
                    ]            
            )->join('users', 'users.id', '=', 'tarefas.doit')
            ->leftjoin('suggestions', 'suggestions.tarefa_id', '=', 'tarefas.id')
            ->orderBy('nickname')
            ->select('tarefas.*', 'suggestions.id as id_suggestion', 'users.name', 'users.nickname','users.avatar')->get(); 
                                  

            if($tarefas->count() > 0){
                foreach ($tarefas as $key => $ta) {

                    $dt = new Carbon($ta->created_at, 'America/Maceio');                
                    $arrayAtivas[] = ['id' => $ta->id, 'isdoit' => true ,'status' => $ta->status, 'texto' => $ta->texto, 'status' => $ta->status, "privado" => $ta->privado ,"tempoCadastada" => $dt->diffForHumans(Carbon::now('America/Maceio')), 'avatar' => $ta->avatar, 'name' => $ta->name, 'nickname' => $ta->nickname];         
                }
                $jsonAtivas = array('tarefasAtivas' => $arrayAtivas);
                $json = $jsonAtivas;
            }

            
            if($tarefasConcluidas->count() > 0){
                foreach ($tarefasConcluidas as $key => $tc) {
                    if($tc->id_suggestion != '')
                        $tarefasConcluidas[$key]['hasSuggestion'] = true;
                    else
                        $tarefasConcluidas[$key]['hasSuggestion'] = false;

                    $dt = new Carbon($tc->created_at, 'America/Maceio');                
                    $arrayConcluidas[] = ['id' => $tc->id,'isdoit' => true, 'hasSuggestion' => $tc->hasSuggestion, 'texto' => $tc->texto , 'status' => $tc->status, "privado" => $tc->privado, "tempoCadastada" => $dt->diffForHumans(Carbon::now('America/Maceio')) , 'avatar' => $tc->avatar, 'name' => $tc->name, 'nickname' => $tc->nickname];         
                }
                $jsonConcluidas = array('tarefasConcluidas' => $arrayConcluidas);

                if($jsonAtivas)
                    $json = array_merge($jsonAtivas, $jsonConcluidas);
                else
                    $json = $jsonConcluidas;
            }            
                        
            echo json_encode($json);die();           
        }
        
    }

    public function recusarDoIt(){

        if(Request::ajax()){
            $id = Request::input('id');
            $tarefa = Tarefa::find($id);            
            $tarefa->status = "R";            
            $tarefa->save();

            /*Envia notificação*/
            $message = "Recusou a tarefa doit: <strong>".$tarefa->texto."</strong>";
            $id = Notification::insertGetId(
                    ['user_id' =>  $tarefa->user_id, 'sender_id' => $tarefa->doit, 'message' => $message, 'status' => 'I', 'created_at' => Carbon::now()]
                    );

            $userNoti = User::find($tarefa->user_id);
            $notification = Notification::find($id);
            $notification->link= "redirectFor('/tarefa/doit/".$userNoti->nickname."'); return false;";
            $notification->save();


            $tipoOrdenacao = $this->getCategoriaParaOrdenacao($tarefa->categoria_id);
            
            $json = [];

            $tarefasAtivas = Tarefa::where(
                    [                        
                        ['doit',Auth::user()->id],
                        ['status', 'A'],
                        ['categoria_id', $tarefa->categoria_id],
                    ]            
            )->leftjoin('users', 'users.id', '=', 'tarefas.user_id')
            ->orderBy('nickname')
            ->select('tarefas.*', 'users.name', 'users.nickname','users.avatar')
            ->orderBy($tipoOrdenacao['prioridade'], $tipoOrdenacao['ordem'])->get(); 

            if ($tarefasAtivas->count() > 0) {
                foreach ($tarefasAtivas as $key => $ta) {
                    $isdoit = false;
                    if($ta->user_id != $ta->doit){
                        $isdoit = true;
                    }
                    $dt = new Carbon($ta->created_at, 'America/Maceio');                
                    $arrayAtivas[] = ['id' => $ta->id, 'isdoit' => $isdoit, 'texto' => $ta->texto, 'status' => $ta->status, "privado" => $ta->privado ,"tempoCadastada" => $dt->diffForHumans(Carbon::now('America/Maceio')), 'avatar' => $ta->avatar, 'name' => $ta->name, 'nickname' => $ta->nickname];         
                }
                $jsonAtivas = array('tarefasAtivas' => $arrayAtivas);

                $json = $jsonAtivas;
            }

            $tarefasConcluidas = Tarefa::where(
                    [                        
                        ['tarefas.doit',Auth::user()->id],
                        ['tarefas.status', 'C'],
                        ['tarefas.categoria_id', $tarefa->categoria_id],
                        ['tarefas.data_conclusao', '>=', Carbon::today()],
                        ['tarefas.data_conclusao', '<', Carbon::tomorrow()],
                    ]            
            )->leftjoin('users', 'users.id', '=', 'tarefas.doit')
            ->leftjoin('suggestions', 'suggestions.tarefa_id', '=', 'tarefas.id')
            ->orderBy('nickname')
            ->select('tarefas.*', 'suggestions.id as id_suggestion',  'users.name', 'users.nickname','users.avatar')->get(); 

        

            if ($tarefasConcluidas->count() > 0) {        
                foreach ($tarefasConcluidas as $key => $tc) {
                    $dt = new Carbon($tc->created_at, 'America/Maceio');                
                    $arrayConcluidas[] = ['id' => $tc->id, 'texto' => $tc->texto , 'status' => $tc->status, "privado" => $tc->privado, "tempoCadastada" => $dt->diffForHumans(Carbon::now('America/Maceio')) , 'avatar' => $tc->avatar, 'name' => $tc->name, 'nickname' => $tc->nickname];         
                }
                $jsonConcluidas = array('tarefasConcluidas' => $arrayConcluidas);

                if($jsonAtivas)
                    $json = array_merge($jsonAtivas, $jsonConcluidas);
                else
                    $json = $jsonConcluidas;
            }
                        
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
                    if($item['id'] == $tarefa->id){                        
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


    /*===================================== Métodos Privado =========================================================*/
    private function getCategoriaParaOrdenacao($categoria_id){
        $ordem = 'asc';
        $prioridade = 'created_at';

        $categoria = Categoria::find($categoria_id);
        if($categoria->prioridade == 'dataDesc'){
            $ordem = "desc";
        }elseif ($categoria->prioridade == 'Prioridade') {
            $prioridade = 'posicao';
        }        

        return array('ordem' => $ordem, 'prioridade' => $prioridade);
    }


}
