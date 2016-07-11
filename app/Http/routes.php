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
Route::get('/profile', 'UserController@profile');
Route::post('/profile', 'UserController@update_avatar');
Route::post('/profile/novaCategoria', 'UserController@add_categoria');

Route::post('/tarefa/adiciona', 'TarefaController@adiciona');

