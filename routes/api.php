<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'RegisterController@register');
Route::post('/login', 'LoginController@login');
Route::post('/logout', 'LoginController@logout');

Route::group(['namespace' => 'Api'], function() {

  Route::get('/users', 'UserController@index');
  Route::post('/users', 'RegisterController@register');
  Route::put('/users/{id}', 'UserController@update');
  Route::delete('/users/{id}', 'UserController@destroy');

  Route::get('/majors', 'JurusanController@index');
  Route::post('/majors', 'JurusanController@store');
  Route::put('/majors/{id}', 'JurusanController@update');
  Route::delete('/majors/{id}', 'JurusanController@destroy');

  Route::get('/classrooms', 'KelasController@index');
  Route::get('/classrooms/count', 'KelasController@count');
  Route::post('/classrooms', 'KelasController@store');
  Route::put('/classrooms/{id}', 'KelasController@update');
  Route::delete('/classrooms/{id}', 'KelasController@destroy');

  Route::get('/transactions', 'PembayaranController@index');
  Route::post('/transactions', 'PembayaranController@store');
  Route::put('/transactions/{id}', 'PembayaranController@update');
  Route::delete('/transactions/{id}', 'PembayaranController@destroy');

  Route::get('/students', 'SiswaController@index');
  Route::get('/students/count', 'SiswaController@count');
  Route::post('/students', 'SiswaController@store');
  Route::put('/students/{id}', 'SiswaController@update');
  Route::delete('/students/{id}', 'SiswaController@destroy');

  Route::get('/tuitions', 'SppController@index');
  Route::post('/tuitions', 'SppController@store');
  Route::put('/tuitions/{id}', 'SppController@update');
  Route::delete('/tuitions/{id}', 'SppController@destroy');

  Route::get('/payments', 'PembayaranController@index');
  Route::post('/payments', 'PembayaranController@store');
  Route::put('/payments/{id}', 'PembayaranController@update');
  Route::delete('/payments/{id}', 'PembayaranController@destroy');

});
