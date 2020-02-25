<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//List tasks
Route::get('tasks', 'TaskController@index');

//List single task
Route::get('task/{id}', 'TaskController@show');

//create new task
Route::post('task', 'TaskController@store');

//update a task
Route::put('task', 'TaskController@store');

//delete task
Route::delete('task/{id}', 'TaskController@destroy');




