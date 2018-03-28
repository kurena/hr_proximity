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
Route::get('/empleado/registrar', 'EmployeeController@showForm');
Route::get('/empleado/consultar', 'EmployeeController@showTable');
Route::get('/empleado/consultar/{id}', 'EmployeeController@showEmployee');
Route::get('/empleado/editar/{id}', 'EmployeeController@showEdit');
Route::post('/empleado/registrar', 'EmployeeController@store');
Route::post('/empleado/editar/{id}', 'EmployeeController@update');
Route::delete('/empleado/eliminar/{id}', 'EmployeeController@delete');

//Vacaciones
Route::get('/vacaciones', 'VacationsController@showView');
Route::post('/vacaciones/solicitar', 'VacationsController@store');

//Permisos
Route::get('/permisos', 'PermissionsController@showView');
Route::post('/permisos/solicitar', 'PermissionsController@store');