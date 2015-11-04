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
    //return view('welcome');
    return view('app');
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

	Route::resource('project.member', 'ProjectMemberController', ['except' => ['create', 'edit', 'update']]);
	// Exemplo: /project/{project}/member/{member}

	Route::group(['middleware' => 'check.project.permission', 'prefix' => 'project'], function(){

		// 04.08.2015 - Project Note
		Route::get('{id}/note', 'ProjectNoteController@index');
		Route::get('{id}/note/{noteId}', 'ProjectNoteController@show');
		Route::post('{id}/note', 'ProjectNoteController@store');
		Route::put('{id}/note/{noteId}', 'ProjectNoteController@update');
		Route::delete('{id}/note/{noteId}', 'ProjectNoteController@destroy');

		// 27.09.2015 - Project File
		Route::get('{id}/file', 'ProjectFileController@index');
		Route::get('{id}/file/{fileId}', 'ProjectFileController@show');
		Route::get('{id}/file/{fileId}/download', 'ProjectFileController@showFile');
		Route::post('{id}/file', 'ProjectFileController@store');
		Route::put('{id}/file/{fileId}', 'ProjectFileController@update');
		Route::delete('{id}/file/{fileId}', 'ProjectFileController@destroy');
	
		// 23.08.2015 - Project Task
		Route::get('{id}/task', 'ProjectTaskController@index');
		Route::get('{id}/task/{taskId}', 'ProjectTaskController@show');
		Route::post('{id}/task', 'ProjectTaskController@store');
		Route::put('{id}/task/{taskId}', 'ProjectTaskController@update');
		Route::delete('{id}/task/{taskId}', 'ProjectTaskController@destroy');


		// Todos os membros do projeto (04.08.2015)
		//Route::get('project/{id}/members', 'ProjectController@members');
		Route::get('{id}/members', 'ProjectMemberController@members');


		//Route::post('{id}/file', 'ProjectFileController@store');
		//Route::delete('{id}/file', 'ProjectFileController@destroy');
	});



	Route::get('user/authenticated', 'UserController@authenticated');
	Route::resource('user', 'UserController', ['except' => ['create', 'edit']]);


});