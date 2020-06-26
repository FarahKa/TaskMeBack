<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

// Login Routes...
//logging in: give it json with email & password, should return you the logged in user:
Route::post('login', ['as' => 'login.post', 'uses' => 'AuthController@login']);
Route::post('logout', ['as' => 'logout.post', 'uses' => 'AuthController@logout']);
Route::post('logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);

// Registration Routes...
Route::post('register', ['as' => 'register.post', 'uses' => 'Auth\RegisterController@register']);

// Password Reset Routes... NOT WORKED ON YET
Route::get('password/reset', ['as' => 'password.reset', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
Route::post('password/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
Route::get('password/reset/{token}', ['as' => 'password.reset.token', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'Auth\ResetPasswordController@reset']);
//Auth::routes();

//dont pay attention to this
Route::group(['middleware' => ['web']], function () {
    // your routes here
});

//this too
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//adding a skill to a connected worker:
Route::get('addskill/{name}', array('middleware' => 'cors', 'uses' =>'WorkerController@addSkill'));

//list all workers:
Route::get('workers', array('middleware' => 'cors', 'uses' =>'WorkerController@index'));

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


//post stuff:
//you can check out the controllers to see the info the request expects
Route::get('posts', array('middleware' => 'cors', 'uses' =>'PostController@index'));

//list posts for 1 category (using the category's name)
Route::get('posts_by_category/{name}', array('middleware' => 'cors', 'uses' =>'PostController@posts_by_category'));
//list posts for 1 task(using the task's name)
Route::get('posts_by_task/{name}', array('middleware' => 'cors', 'uses' =>'PostController@posts_by_task'));
//list posts for 1 user(using the user's ID)
Route::get('posts_by_user/{id}', array('middleware' => 'cors', 'uses' =>'PostController@posts_by_user'));
//list posts for 1 country(using the country name)
Route::get('posts_by_country/{name}', array('middleware' => 'cors', 'uses' =>'PostController@posts_by_country'));
//list posts for 1 country(using the city name)
Route::get('posts_by_city/{name}', array('middleware' => 'cors', 'uses' =>'PostController@posts_by_city'));


//creating a new post
Route::post('post', array('middleware' => 'cors', 'uses' =>'PostController@store'));
//modifying a post (expects the same info you would use for creation
//since the id is the same, will modify the old one
//just has to be put  method instead of post method
Route::put('post', array('middleware' => 'cors', 'uses' =>'PostController@store'));
//showing 1 post by id
Route::get('post/{id}', array('middleware' => 'cors', 'uses' =>'PostController@show'));
//deleting a post
Route::delete('post/{id}', array('middleware' => 'cors', 'uses' =>'PostController@destroy'));


//Ad stuff:
//listing all ads:
Route::get('ads', array('middleware' => 'cors', 'uses' =>'AdController@index'));
//creating an ad:
Route::post('ad', array('middleware' => 'cors', 'uses' =>'AdController@store'));
//modifying an ad:
Route::put('ad', array('middleware' => 'cors', 'uses' =>'AdController@store'));
//ads by user:
Route::get('ads_by_user/{id}', array('middleware' => 'cors', 'uses' =>'AdController@ads_by_user'));
//showing 1 ad by id
Route::get('ad/{id}', array('middleware' => 'cors', 'uses' =>'AdController@show'));
//deleting an ad
Route::delete('ad/{id}', array('middleware' => 'cors', 'uses' =>'AdController@destroy'));
//list ads for 1 country(using the country name)
Route::get('ads_by_country/{name}', array('middleware' => 'cors', 'uses' =>'AdController@ads_by_country'));
//list ads for 1 country(using the city name)
Route::get('ads_by_city/{name}', array('middleware' => 'cors', 'uses' =>'AdController@ads_by_city'));
