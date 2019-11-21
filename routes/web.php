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

Route::get('/', function () {
    return view('welcome');
});

Route::post ( '/vueusers', 'HomeController@storeUser' );
Route::get ( '/vueusers', 'HomeController@readUsers' );
Route::post ( '/vueusers/{id}', 'HomeController@deleteUser' );
Route::post ( '/editusers/{id}', 'HomeController@editUser' );