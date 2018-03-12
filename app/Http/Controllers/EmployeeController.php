<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Employee;

class EmployeeController extends Controller
{
    public function show () {
        if (Auth::user()) {
            $idEmp = Auth::user()->id_empleado;
            $empleado = DB::select('select * from empleado where cedula = ?', [$idEmp]);
            $admins = DB::select('select * from empleado where rol = ?', ['administrador']);
        } else {
            $empleado = [0 => ''];
            $admins = [0 => ''];
            return redirect()->route('login');
        }
    	return view('employeeRegister', ['empleado' => $empleado[0], 'admins' => $admins]);
    }

    public function store(Request $request) {
      $employee = new Employee;

      $employee->nombre = $request->nombre;
      $employee->apellidos = $request->apellidos;
      $employee->cedula = $request->cedula;
      $employee->email = $request->email;
      $employee->direccion = $request->direccion;
      $employee->celular = $request->celular;
      $employee->puesto = $request->puesto;
      $employee->salario = $request->salario;
      $employee->fecha_nacimiento = $request->fecha_nacimiento;
      $employee->fecha_ingreso = $request->fecha_ingreso;
      $employee->rol = $request->selectRol;
      $employee->id_manager = $request->selectManager;

      $employee->save();
    }
}
