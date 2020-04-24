<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function(){

    Route::resource('projects', 'ProjectController');


	Route::post('projects/{project}/tasks','ProjectTaskController@store');
	Route::patch('tasks/{task}','ProjectTaskController@update');

	Route::post('projects/{project}/invitations', 'ProjectInvitationController@store');
}); 


Auth::routes();
Route::get('login-guest', 'Auth\LoginController@loginAsGuest');

Route::get('reset','DatabaseSeederController')->middleware('can:reset-demo');
