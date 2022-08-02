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
Route::post('/login','App\Http\Controllers\UserController@login');
Route::post('/register','App\Http\Controllers\UserController@register');
Route::post('/logout','App\Http\Controllers\UserController@logout')->middleware('auth:sanctum');
// Route::post('login', [UserController::class, 'login']);
// Route::post('register', [App\Http\Controllers\UserController::class, 'register']);
// Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['prefix' => 'user','middleware' => 'auth:sanctum'], function() {
    Route::get('/me','App\Http\Controllers\UserController@user');
    Route::get('/list','App\Http\Controllers\UserController@userlist');
    Route::post('/create','App\Http\Controllers\UserController@create');
    Route::post('/update/{id}','App\Http\Controllers\UserController@update');
    Route::post('/status-update/{id}','App\Http\Controllers\UserController@statusUpdate');
    Route::delete('/delete/{id}','App\Http\Controllers\UserController@delete');
    Route::post('/status','App\Http\Controllers\UserController@userStatus');
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


