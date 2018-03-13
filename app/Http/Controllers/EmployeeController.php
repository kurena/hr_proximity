<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Employee;
use Validator;

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

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'cedula' => 'required|numeric|max:9|min:9|unique:empleado,cedula',
            'celular' => 'required|numeric|max:8|min:8',
            'email' => 'required|email|max:255',
            'direccion' => 'required|string|max:255',
            'puesto' => 'required|string|max:255',
            'salario' => 'required|numeric|max:11',
            'fecha_ingreso' => 'required|date',
            'fecha_nacimiento' => 'required|date'
        ]);

        if ($validator->fails()) {
            return redirect('empleado/registrar')
                        ->withErrors($validator)
                        ->withInput();
        }

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
