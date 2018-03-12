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
//Main
Route::get('/', 'MainController@show');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//Empleados
Route::get('/empleado/registrar', 'EmployeeController@show');
Route::post('/empleado/registrar', 'EmployeeController@store');
