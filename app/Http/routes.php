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

Route::auth();
Route::get('/', 'TarefaController@index');
Route::get('/home', 'HomeController@index');
Route::post('/home/getTimeline', 'HomeController@getTimeline');
Route::get('/admin', 'AdminController@index');

/*======================================================= PROFILE ======================================================= */
/*GET*/
Route::get('/profile/{nickname?}', 'UserController@index');
Route::get('/profile/{nickname?}/{categoria?}', 'UserController@index');
/*POST*/
Route::post('/profile', 'UserController@update_avatar');
Route::post('/profile/follow', 'UserController@follow');
Route::post('/profile/unfollow', 'UserController@unFollow');
Route::post('/profile/favorite', 'UserController@favorite');
Route::post('/profile/unfavorite', 'UserController@unFavorite');
Route::post('/profile/permit', 'UserController@permit');
Route::post('/profile/unpermit', 'UserController@unPermit');
Route::post('/profile/validaSenha', 'UserController@validaSenha');
Route::post('/profile/updatepassword', 'UserController@update_password');
Route::post('/profile/updateprofile', 'UserController@update_profile');
Route::post('/profile/getusersearch', 'UserController@getUserSearch');
Route::post('/profile/getcategoriasdoitbynickname', 'UserController@getCategoriasDoItByNickname');

/*======================================================= Tarefas ======================================================= */

/*GET*/
Route::get('/tarefa/getMyCategories', 'TarefaController@getMyCategories');
Route::get('/tarefa/listar/{tipo?}', 'TarefaController@listByStatus');
Route::get('/tarefa/doit/{nickname?}', 'TarefaController@indexDoit');
Route::get('/tarefa/{categoria?}', 'TarefaController@index');
Route::get('/tarefa/ordenar/{categoria_id?}/{tipo?}', 'TarefaController@ordenar');
/*POST*/
Route::post('/tarefa/getSuggestion', 'TarefaController@getSuggestion');
Route::post('/tarefa/adiciona', 'TarefaController@adiciona');
Route::post('/tarefa/copiar', 'TarefaController@copiarTarefa');
Route::post('/tarefa/doit', 'TarefaController@doit');
Route::post('/tarefa/novaCategoria', 'TarefaController@add_categoria');
Route::post('/tarefa/prioridade/{categoria_id?}', 'TarefaController@ordenarPrioridade');
Route::post('/tarefa/concluir', 'TarefaController@concluir');
Route::post('/tarefa/concluirByFilter', 'TarefaController@concluirByFilter');
Route::post('/tarefa/remover', 'TarefaController@remover');
Route::post('/tarefa/removerdoit', 'TarefaController@removerDoIt');
Route::post('/tarefa/recusardoit', 'TarefaController@recusarDoIt');
Route::post('/tarefa/suggestion', 'TarefaController@adiciona_sugestao');

/*======================================================= Notification ======================================================= */
Route::get('/notification', 'NotificationController@index');
Route::get('/notification/verificanotifications', 'NotificationController@verificanotifications');
Route::post('/notification/setStatus', 'NotificationController@setStatusNotification');



