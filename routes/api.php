<?php


use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// auth routes 

Route::post('login', "Api\UserController@Login");
Route::post('signup', "Api\UserController@Register");

Route::group(["middleware" => "auth:api"], function () {
    Route::resource('board', 'Api\BoardController');
    Route::resource('list', 'Api\ListController')->except(["index", "show", "create", "edit"]);
    Route::resource('task', 'Api\TaskController')->except(["index", "show", "create", "edit"]);
    Route::get('list/{board_id}', 'Api\ListController@index');
    Route::get('task/list/{list_id}', "Api\TaskController@index");
});
