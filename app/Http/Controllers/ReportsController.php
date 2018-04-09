<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use \Datetime;
use \DateInterval;
use App\Vacations;
use Validator;

class ReportsController extends Controller
{
    private $PERIOD_DAYS = 10;

    public function getAuthUser () {
      $idEmp = Auth::user()->id_empleado;
      $empleado = DB::select('select a.email as admin_email, a.nombre as admin_nombre, a.apellidos as admin_apellidos, e.nombre, e.apellidos, e.cedula, e.id_manager, e.fecha_ingreso, e.email  from empleado e inner join empleado a ON e.id_manager=a.cedula where e.cedula = ?', [$idEmp]);
      return $empleado;
    }

    public function showView () {
      if (Auth::user()) {
        $empleado = $this->getAuthUser()[0];
        $employees = DB::select('select nombre, cedula, apellidos from empleado'); 
      } else {
        $empleado = [];
        $employees = [];
        return redirect()->route('login');
      }    
    	return view('reportsView', ['empleado' => $empleado, 'employees' => $employees]);
    }

    public function createEmployeeReport (Request $request) {
      if (Auth::user()) {
        $reporter = $this->getAuthUser()[0];
        $empId = $request->selectEmployee;
        $employee = DB::select("select nombre, apellidos, cedula, direccion, celular, puesto, salario, date_format(fecha_nacimiento, '%d/%m/%Y') as fecha_nacimiento, date_format(fecha_ingreso, '%d/%m/%Y') as fecha_ingreso, email from empleado where cedula=?", [$empId])[0];
        $date = date('d/m/y');
      } else {
        $reporter = [];
        return redirect()->route('login');
      }    
      return view('employeeReport', ['reporter' => $reporter, 'creationDate' => $date, 'employee' => $employee]);
    }

}
