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
Route::get('/cambiarContrasena','MainController@showChangePasswordForm');
Route::post('/cambiarContrasena','MainController@changePassword');
Auth::routes();

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
Route::delete('/vacaciones/eliminar/{id}', 'VacationsController@delete');
Route::get('/vacaciones/modificar/{id}', 'VacationsController@getVacationInformation');
Route::post('/vacaciones/modificar/{id}', 'VacationsController@updateVacation');

//Permisos
Route::get('/permisos', 'PermissionsController@showView');
Route::get('/permisos/aprobar', 'PermissionsController@showApprovalView');
Route::post('/permisos/actualizarestado', 'PermissionsController@updateStatus');
Route::post('/permisos/solicitar', 'PermissionsController@store');
Route::delete('/permisos/eliminar/{id}', 'PermissionsController@delete');
Route::get('/permisos/modificar/{id}', 'PermissionsController@getPermissionInformation');
Route::post('/permisos/modificar/{id}', 'PermissionsController@updatePermission');

//Incapacidades
Route::get('/incapacidades', 'IncapacityController@showView');
Route::post('/incapacidades/ingresar', 'IncapacityController@store');
Route::delete('/incapacidades/eliminar/{id}', 'IncapacityController@delete');
Route::get('/incapacidades/modificar/{id}', 'IncapacityController@getIncapacityInformation');
Route::post('/incapacidades/modificar/{id}', 'IncapacityController@updateIncapacity');

//Viaticos
Route::get('/viaticos', 'TravelExpenseController@showView');
Route::get('/viaticos/empleado/{id}', 'TravelExpenseController@showEmployeeView');
Route::post('/viaticos/ingresar', 'TravelExpenseController@store');
Route::get('/viaticos/comprobacion/{id}', 'TravelExpenseController@showCalculationView');
Route::post('/viaticos/comprobacion/ingresar', 'TravelExpenseController@storeCalculation');
Route::delete('/viaticos/eliminar/{id}', 'TravelExpenseController@delete');
Route::get('/viaticos/modificar/{id}', 'TravelExpenseController@getTravelExpenseInformation');
Route::post('/viaticos/modificar/{id}', 'TravelExpenseController@updateTravelExpense');
Route::delete('/viaticos/comprobacion/eliminar/{id}', 'TravelExpenseController@deleteCalculation');
Route::get('/viaticos/comprobacion/modificar/{id}', 'TravelExpenseController@getCalculationInformation');
Route::post('/viaticos/comprobacion/modificar/{id}', 'TravelExpenseController@updateCalculation');

//Contratos
Route::get('/contratos', 'ContractsController@showView');
Route::post('/contratos/ingresar', 'ContractsController@store');
Route::get('/contratos/comprobacion/{id}', 'ContractsController@showCalculationView');
Route::post('/contratos/comprobacion/ingresar', 'ContractsController@storeCalculation');
Route::delete('/contratos/eliminar/{id}', 'ContractsController@delete');
Route::get('/contratos/modificar/{id}', 'ContractsController@getContractInformation');
Route::post('/contratos/modificar/{id}', 'ContractsController@updateContract');
Route::delete('/contratos/comprobacion/eliminar/{id}', 'ContractsController@deleteCalculation');
Route::get('/contratos/comprobacion/modificar/{id}', 'ContractsController@getCalculationInformation');
Route::post('/contratos/comprobacion/modificar/{id}', 'ContractsController@updateCalculation');

//Reportes
Route::get('/reportes', 'ReportsController@showView');
Route::post('/reportes/generar/datos', 'ReportsController@createEmployeeReport');
Route::post('/reportes/generar/vacaciones', 'ReportsController@createVacationsReport');
Route::post('/reportes/generar/ausencias', 'ReportsController@createPermissionsReport');
Route::post('/reportes/generar/incapacidades', 'ReportsController@createIncapacityReport');
Route::get('/reportes/generar/contratos/{id}', 'ReportsController@createContractsReport');
Route::get('/reportes/generar/viaticos/{id}', 'ReportsController@createTravelExpenseReport');