<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Tarefa;
use App\User;
use Carbon\Carbon;
use Auth;


class HomeController extends Controller {
    
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $tarefasPublicas = Tarefa::where(
                [
                    ['tarefas.doit', '<>' , Auth::user()->id],                    
                    ['tarefas.status', 'A'],
                    ['tarefas.privado', '0'],
                ]            
        )->leftjoin('users', 'users.id' , '=', 'tarefas.user_id')
        ->select('tarefas.*', 'users.name', 'users.nickname', 'users.avatar')
        ->orderBy('created_at',"desc")->get(); 

        foreach ($tarefasPublicas as $key => $t) {
            $dt = new Carbon($t->created_at, 'America/Maceio');
            $tarefasPublicas[$key]['tempoCadastada'] = $dt->diffForHumans(Carbon::now('America/Maceio'));         
        }        

        if(Auth::user()->followers->count() == 0){
            $people = User::where('id','<>',Auth::user()->id)->take(5)->get();
        }
        return view('home', array(
                    'tarefasPublicas' => $tarefasPublicas,
                    'people'          => (empty($people) ?  null : $people),
        ));
    }

    public function getTimeline(Request $request) {
        if($request->ajax()){
            $totalTarefas      = $request->input('totalTarefas'); 
            $tarefasPublicas = Tarefa::where(
                [
                    ['tarefas.doit', '<>' , Auth::user()->id],                    
                    ['tarefas.status', 'A'],
                    ['tarefas.privado', '0'],
                ]            
            )->leftjoin('users', 'users.id' , '=', 'tarefas.user_id')
            ->select('tarefas.*', 'users.name', 'users.nickname', 'users.avatar')
            ->orderBy('created_at',"desc")->get();           

            
            
            if($totalTarefas < $tarefasPublicas->count()){
                $json = [];
                foreach ($tarefasPublicas as $key => $t) {
                    $dt = new Carbon($t->created_at, 'America/Maceio');
                    $tarefasPublicas[$key]['tempoCadastada'] = $dt->diffForHumans(Carbon::now('America/Maceio'));         

                    $arrayTarefas[] = ['id' => $t->id,  'texto' => $t->texto , 'status' => $t->status, "tempoCadastada" => $dt->diffForHumans(Carbon::now('America/Maceio')) , 'avatar' => $t->avatar, 'name' => $t->name, 'nickname' => $t->nickname];                 

                }
                $jsontarefas = array('tarefas' => $arrayTarefas);
                $jsonTotalTarefas = array('totalTarefas' => $tarefasPublicas->count());

                $json = array_merge($jsontarefas, $jsonTotalTarefas);
                echo json_encode($json);die();    

            }else{
                 echo json_encode([]);die();    
            }
        }
    }




}
