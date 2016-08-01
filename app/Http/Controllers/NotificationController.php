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
        $notifications  = Notification::where(
                                [
                                    ['user_id', Auth::user()->id],
                                    ['status', 'I'],
                                ]
                        )->join('users', 'users.id', '=', 'notifications.sender_id')
                        ->select('notifications.*', 'users.name', 'users.nickname','users.avatar')
                        ->orderBy('created_at', 'asc')->get();

        $json = [];
        if($notifications->count() > 0){
            foreach ($notifications as $key => $n) { 
                $vIDs[] = $n->id;               
                $dt = new Carbon($n->created_at, 'America/Maceio');                                                
                $json[] = ['id' => $n->id, 'message' => $n->message, "data" => $dt->diffForHumans(Carbon::now('America/Maceio')) , 'sender_id' => $n->sender_id, 'avatar' => $n->avatar, 'name' => $n->name, 'nickname' => $n->nickname];
            }

            Notification::whereIn('id', $vIDs)->update(['status' => 'A']);
        }

        

        echo json_encode($json);die();
        
    }
    
}
