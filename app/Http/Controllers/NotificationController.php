<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Request;
use App\Http\Requests;
use App\Tarefa;
use App\Notification;
use App\User;
use App\Categoria;
use Carbon\Carbon;
use Auth;


class NotificationController extends Controller {

    public function __construct(){
        $this->middleware('auth');
    }

    public function verificanotifications(){

        /*
        I = Inativa     => Quando o usuário ainda não viu.
        A = Ativa       => Quando o usuário recebe o modal mas ainda não clicou para ver.
        V = Visualizada => Quando o usuário visualiza.
        */
        $notificationsAtivas  = Notification::where(
                                [
                                    ['user_id', Auth::user()->id],                                    
                                    ['notifications.status',"A"],                                    
                                ])->join('users', 'users.id', '=', 'notifications.sender_id')
                                  ->select('notifications.*', 'users.name', 'users.nickname','users.avatar')
                                  ->orderBy('created_at', 'desc')->take(5)->get();                                  
        $qtdAtivas = $notificationsAtivas->count();

        $notificationsVisualizadas = "";
        if( (5 - $qtdAtivas) > 0){
            $valor = 5 - $qtdAtivas;
            $notificationsVisualizadas  = Notification::where(
                                [
                                    ['user_id', Auth::user()->id],                                    
                                    ['notifications.status',"V"],                                    
                                ])->join('users', 'users.id', '=', 'notifications.sender_id')
                                  ->select('notifications.*', 'users.name', 'users.nickname','users.avatar')
                                  ->orderBy('created_at', 'desc')->take($valor)->get(); 
        }


        $notificationsInativas  = Notification::where(
                                [
                                    ['user_id', Auth::user()->id],
                                    ['status', 'I'],
                                ]
                        )->join('users', 'users.id', '=', 'notifications.sender_id')
                        ->select('notifications.*', 'users.name', 'users.nickname','users.avatar')
                        ->orderBy('created_at', 'desc')->get();

        $json = [];
        $jsonInativas = "";

        if($notificationsInativas->count() > 0){
            foreach ($notificationsInativas as $key => $n) { 
                $vIDs[] = $n->id;               
                $dt = new Carbon($n->created_at, 'America/Maceio');                                                
                $arrayInativas[] = ['id' => $n->id, 'message' => $n->message, "link" => $n->link, "data" => $dt->diffForHumans(Carbon::now('America/Maceio')) , 'sender_id' => $n->sender_id, 'avatar' => $n->avatar, 'name' => $n->name, 'nickname' => $n->nickname];
            }
            $jsonInativas = array('inativas' => $arrayInativas);

            Notification::whereIn('id', $vIDs)->update(['status' => 'A']);
        }

        if($notificationsAtivas->count() > 0){
            foreach ($notificationsAtivas as $key => $n) { 
                $vIDs[] = $n->id;               
                $dt = new Carbon($n->created_at, 'America/Maceio');                                                
                $arrayAtivas[] = ['id' => $n->id,'status' => $n->status, 'message' => $n->message, "link" => $n->link, "data" => $dt->diffForHumans(Carbon::now('America/Maceio')) , 'sender_id' => $n->sender_id, 'avatar' => $n->avatar, 'name' => $n->name, 'nickname' => $n->nickname];
            }

            $jsonAtivas = array('ativas' => $arrayAtivas);         
        }else{
            $arrayAtivas[] = ['total' => 0];
            $jsonAtivas = array('ativas' => $arrayAtivas);    
        }

        $jsonVisualizadas = "";
        if($notificationsVisualizadas){

            if($notificationsVisualizadas->count() > 0){
                foreach ($notificationsVisualizadas as $key => $n) {          
                    
                    $dt = new Carbon($n->created_at, 'America/Maceio');                                                
                    $arrayVisualizadas[] = ['id' => $n->id,'status' => $n->status, 'message' => $n->message, "link" => $n->link, "data" => $dt->diffForHumans(Carbon::now('America/Maceio')) , 'sender_id' => $n->sender_id, 'avatar' => $n->avatar, 'name' => $n->name, 'nickname' => $n->nickname];
                }

                $jsonVisualizadas = array('visualizadas' => $arrayVisualizadas);
            }            
        }

        if($jsonVisualizadas)
            $json1 = array_merge($jsonAtivas, $jsonVisualizadas);
        else
            $json1 = $jsonAtivas;


        if($jsonInativas)            
            $json = array_merge($json1, $jsonInativas); 
        else
            $json = $json1; 

        

        echo json_encode($json);die();
        
    }
    
    public function setStatusNotification(){
        if(Request::ajax()){
            $vIds = explode(",",Request::input('vIds'));            
            Notification::whereIn('id', $vIds)->update(['status' => Request::input('status')]);
        }   
    }


}
