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

Route::get('/', function () {
    return view('welcome');
});

// Clients
Route::get('client', 'ClientController@index');
//Route::post('client', 'ClientController@store');
Route::post('client', 'ClientController@create');
Route::get('client/{id}', 'ClientController@show');
Route::delete('client/{id}', 'ClientController@destroy');
Route::put('client/{id}', 'ClientController@update');


// 04.08.2015 - Project Task
Route::get('project/task', 'ProjectTaskController@index');
Route::post('project/task', 'ProjectTaskController@store');
Route::get('project/task/{id}', 'ProjectTaskController@show');
Route::put('project/task/{id}', 'ProjectTaskController@update');
Route::delete('project/task/{id}', 'ProjectTaskController@destroy');


// 04.08.2015 - Project Note
Route::get('project/{id}/note', 'ProjectNoteController@index');
Route::post('project/{id}/note', 'ProjectNoteController@store');
Route::get('project/{id}/note/{noteId}', 'ProjectNoteController@show');
Route::put('project/{id}/note/{noteId}', 'ProjectNoteController@update');
Route::delete('project/{id}/note/{noteId}', 'ProjectNoteController@destroy');


// Todos os membros do projeto (04.08.2015)
//Route::get('project/{id}/members', 'ProjectController@members');
Route::get('project/{id}/members', 'ProjectMemberController@members');

// Projets (27.07.2015)
Route::get('project', 'ProjectController@index');
Route::post('project', 'ProjectController@create');
Route::get('project/{id}', 'ProjectController@show');
Route::delete('project/{id}', 'ProjectController@destroy');
Route::put('project/{id}', 'ProjectController@update');

