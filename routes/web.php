<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectTaskController;
use App\Http\Controllers\ProjectInvitationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DatabaseSeederController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function(){

    Route::resource('projects', ProjectController::class);


	Route::post('projects/{project}/tasks',[ProjectTaskController::class, 'store']);
	Route::patch('tasks/{task}',[ProjectTaskController::class,'update']);

	Route::post('projects/{project}/invitations', [ProjectInvitationController::class, 'store']);
}); 


Auth::routes();

Route::get('login-guest', [LoginController::class, 'loginAsGuest']);

Route::get('reset', DatabaseSeederController::class)->middleware('can:reset-demo');
