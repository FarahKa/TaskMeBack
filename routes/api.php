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

//List tasks - USES CORS MIDDLEWARE
Route::get('tasks', array('middleware' => 'cors', 'uses' =>'TaskController@index'));

//Route::get('example', array('middleware' => 'cors', 'uses' => 'ExampleController@dummy'));
//List single task
Route::get('task/{id}', array('middleware' => 'cors', 'uses' =>'TaskController@show'));

//create new task
Route::post('task', array('middleware' => 'cors', 'uses' =>'TaskController@store'));

//update a task
Route::put('task', array('middleware' => 'cors', 'uses' =>'TaskController@store'));

//delete task
Route::delete('task/{id}', array('middleware' => 'cors', 'uses' =>'TaskController@destroy'));

//list categories
Route::get('categories', array('middleware' => 'cors', 'uses' =>'CategoryController@index'));
//adding a category - modifying a category
Route::post('category', array('middleware' => 'cors', 'uses' =>'CategoryController@store'));
Route::put('category', array('middleware' => 'cors', 'uses' =>'CategoryController@store'));

//getting one category in particular using id
Route::get('category/{id}', array('middleware' => 'cors', 'uses' =>'CategoryController@show'));

//list tasks for 1 category (using the category's name)
Route::get('tasks_by_category/{name}', array('middleware' => 'cors', 'uses' =>'TaskController@tasks_by_category'));






