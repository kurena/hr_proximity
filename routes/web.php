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
Route::get('/vacaciones/aprobar', 'VacationsController@showApprovalView');
Route::post('/vacaciones/actualizarestado', 'VacationsController@updateStatus');
Route::post('/vacaciones/solicitar', 'VacationsController@store');

//Permisos
Route::get('/permisos', 'PermissionsController@showView');
Route::get('/permisos/aprobar', 'PermissionsController@showApprovalView');
Route::post('/permisos/actualizarestado', 'PermissionsController@updateStatus');
Route::post('/permisos/solicitar', 'PermissionsController@store');

//Incapacidades
Route::get('/incapacidades', 'IncapacityController@showView');
Route::post('/incapacidades/ingresar', 'IncapacityController@store');

//Viaticos
Route::get('/viaticos', 'TravelExpenseController@showView');
Route::get('/viaticos/empleado/{id}', 'TravelExpenseController@showEmployeeView');
Route::post('/viaticos/ingresar', 'TravelExpenseController@store');
Route::get('/viaticos/comprobacion/{id}', 'TravelExpenseController@showCalculationView');
Route::post('/viaticos/comprobacion/ingresar', 'TravelExpenseController@storeCalculation');


//Contratos
Route::get('/contratos', 'ContractsController@showView');
Route::post('/contratos/ingresar', 'ContractsController@store');
Route::get('/contratos/comprobacion/{id}', 'ContractsController@showCalculationView');
Route::post('/contratos/comprobacion/ingresar', 'ContractsController@storeCalculation');