<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});*/

Route::auth();

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::get('/admin', 'AdminController@index');

/*Profile */
Route::get('/profile/{nickname?}', 'UserController@index');
Route::get('/profile/{nickname?}/{categoria?}', 'UserController@index');
Route::post('/profile', 'UserController@update_avatar');
Route::post('/profile/follow/', 'UserController@follow');
Route::post('/profile/unfollow/', 'UserController@unFollow');
Route::post('/profile/favorite/', 'UserController@favorite');
Route::post('/profile/unfavorite/', 'UserController@unFavorite');
Route::post('/profile/permit/', 'UserController@permit');
Route::post('/profile/unpermit/', 'UserController@unPermit');




/*Tarefas */
Route::get('/tarefa/{categoria?}', 'TarefaController@index');
Route::get('/tarefa/doit/{nickname?}', 'TarefaController@indexDoit');
Route::post('/tarefa/adiciona', 'TarefaController@adiciona');
Route::post('/tarefa/doit', 'TarefaController@doit');
Route::get('/tarefa/ordenar/{categoria_id?}/{tipo?}', 'TarefaController@ordenar');
Route::post('/tarefa/novaCategoria', 'TarefaController@add_categoria');


Route::post('tarefa/prioridade/{categoria_id?}', 'TarefaController@ordenarPrioridade');
Route::post('tarefa/concluir/', 'TarefaController@concluir');
Route::post('tarefa/remover/', 'TarefaController@remover');
Route::post('tarefa/removerdoit/', 'TarefaController@removerDoIt');
Route::post('tarefa/recusardoit/', 'TarefaController@recusarDoIt');
/*Route::post('tarefa/concluir', function(){
	if(Request::ajax()){
		$id = Request::input('id');
		
    	print_r($id);die();
    }
});*/


