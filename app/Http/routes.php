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

Route::post('oauth/access_token', function(){
	return Response::json(Authorizer::issueAccessToken());
});


Route::group(['middleware' => 'oauth'], function(){

	// Clients
	Route::resource('client', 'ClientController', ['except' => ['create', 'edit']]);
	/*
		Route::get('client', ['middleware' => 'oauth', 'uses' => 'ClientController@index']);
		//Route::get('client', 'ClientController@index');
		//Route::post('client', 'ClientController@store');
		Route::post('client', 'ClientController@create');
		Route::get('client/{id}', 'ClientController@show');
		Route::delete('client/{id}', 'ClientController@destroy');
		Route::put('client/{id}', 'ClientController@update');
	*/

	// middleware Project
	//Route::group(['middleware' => 'CheckProjectOwner'], function(){
	//	Route::resource('project', 'ProjectController', ['except' => ['create', 'edit']]);
	//});

	Route::resource('project', 'ProjectController', ['except' => ['create', 'edit']]);
	

	Route::group(['prefix' => 'project'], function(){
	
		/*
		Route::get('task', 'ProjectTaskController@index');
		Route::post('task', 'ProjectTaskController@store');
		Route::get('task/{id}', 'ProjectTaskController@show');
		Route::put('task/{id}', 'ProjectTaskController@update');
		Route::delete('task/{id}', 'ProjectTaskController@destroy');
		*/
		// 23.08.2015 - Project Task
		Route::get('{projectId}/task', 'ProjectTaskController@index');
		//Route::post('{projectId}/task', 'ProjectTaskController@store');
		Route::get('{projectId}/task/{id}', 'ProjectTaskController@show');
		Route::put('task/{id}', 'ProjectTaskController@update');
		Route::delete('task/{id}', 'ProjectTaskController@destroy');


		// 04.08.2015 - Project Note
		Route::get('{projectId}/note', 'ProjectNoteController@index');
		//Route::post('{id}/note', 'ProjectNoteController@store');
		Route::get('{projectId}/note/{id}', 'ProjectNoteController@show');
		Route::put('note/{id}', 'ProjectNoteController@update');
		Route::delete('note/{id}', 'ProjectNoteController@destroy');

		// Todos os membros do projeto (04.08.2015)
		//Route::get('project/{id}/members', 'ProjectController@members');
		Route::get('{id}/members', 'ProjectMemberController@members');

		Route::post('{id}/file', 'ProjectFileController@store');

		Route::delete('{id}/file', 'ProjectFileController@destroy');
	});
});