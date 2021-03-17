<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['namespace' => 'Api'], function() {
  Route::get('/users', 'UserController@index');

  Route::get('/majors', 'JurusanController@index');
  Route::post('/majors', 'JurusanController@store');
  Route::put('/majors/{id}', 'JurusanController@update');
  Route::delete('/majors/{id}', 'JurusanController@destroy');

  Route::get('/classrooms', 'KelasController@index');
  Route::post('/classrooms', 'KelasController@store');
  Route::put('/classrooms/{id}', 'KelasController@update');
  Route::delete('/classrooms/{id}', 'KelasController@destroy');

  Route::get('/transactions', 'PembayaranController@index');
  Route::post('/transactions', 'PembayaranController@store');
  Route::put('/transactions/{id}', 'PembayaranController@update');
  Route::delete('/transactions/{id}', 'PembayaranController@destroy');

  Route::get('/students', 'SiswaController@index');
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
