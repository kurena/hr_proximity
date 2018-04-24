<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Employee;
use App\Usuario;
use Validator;
use \Datetime;

class EmployeeController extends Controller
{
    public function getAuthUser () {
        $idEmp = Auth::user()->id_empleado;
        $empleado = DB::select('select * from empleado where cedula = ?', [$idEmp]);
        return $empleado;
    }

    public function showForm () {
        if (Auth::user()) {
            $empleado = $this->getAuthUser();
            $admins = DB::select('select * from empleado where rol = ?', ['administrador']);
        } else {
            $empleado = [0 => ''];
            $admins = [0 => ''];
            return redirect()->route('login');
        }
    	return view('employeeRegister', ['empleado' => $empleado[0], 'admins' => $admins, 'editView' => false, 'uniqueView' => false]);
    }

    public function showTable() {
        if (Auth::user()) {
            $empleado = $this->getAuthUser();
            $empleados = DB::select("select u.nombre_usuario,e.cedula,e.nombre,e.apellidos,e.email,e.puesto, date_format(e.fecha_ingreso, '%d-%m-%Y') as fecha_ingreso,
            e.rol,e.salario,e.direccion,e.celular, date_format(e.fecha_nacimiento, '%d-%m-%Y') as fecha_nacimiento, a.nombre as admin_nombre, 
            a.apellidos as admin_apellidos from empleado e inner join empleado a ON e.id_manager=a.cedula inner join usuario u on e.cedula=u.id_empleado");
        } else {
            $empleado = [0 => ''];
            $empleados = [0 => ''];
            return redirect()->route('login');
        }
        if ($empleado[0]->rol != 'administrador') {
            return redirect('/')->with('error', 'Permisos insuficientes!');
        }
        return view('employeeShow', ['empleado' => $empleado[0], 'empleados' => $empleados ]);
    }

    public function showEdit(Request $request) {
        if (Auth::user()) {
            $empleado = DB::select("select u.id as usuario_id, u.nombre_usuario, e.cedula, e.nombre, e.apellidos, e.direccion, e.puesto, e.salario, e.rol, e.id_manager, e.email, 
            e.celular, date_format(e.fecha_ingreso, '%d-%m-%Y') as fecha_ingreso, 
            date_format(e.fecha_nacimiento, '%d-%m-%Y') as fecha_nacimiento  
            from empleado e inner join usuario u on u.id_empleado = e.cedula where e.cedula = ?", [$request->id]);
            if (!$empleado) {
                return redirect('/');
            }
            $admins = DB::select('select * from empleado where rol = ?', ['administrador']);
        } else {
            $empleado = [0 => ''];
            $admins = [0 => ''];
            return redirect()->route('login');
        }
    	return view('employeeRegister', ['empleado' => $empleado[0], 'admins' => $admins, 'editView' => true, 'uniqueView' => false]);    
    }

    public function showEmployee(Request $request) {
        if (Auth::user()) {
            $empleado = DB::select('select * from empleado where cedula = ?', [$request->id]);;
            $admins = DB::select('select * from empleado where rol = ?', ['administrador']);
        } else {
            $empleado = [0 => ''];
            $admins = [0 => ''];
            return redirect()->route('login');
        }
        $emp = $this->getAuthUser();
        if ($emp[0]->cedula != $request->id) {
            return redirect('/')->with('error', 'Permisos insuficientes!');
        }
    	return view('employeeRegister', ['empleado' => $empleado[0], 'admins' => $admins, 'editView' => true, 'uniqueView' => true]);    
    }

    public function store(Request $request) {
        $employee = new Employee;
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'cedula' => 'required|numeric|digits:9|unique:empleado,cedula',
            'celular' => 'required|digits:8',
            'email' => 'required|email|max:255|unique:empleado,email',
            'direccion' => 'required|string|max:255',
            'puesto' => 'required|string|max:255',
            'salario' => 'required|numeric',
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
        $date = new DateTime($request->fecha_nacimiento);
        $employee->fecha_nacimiento = $date->format('Y-m-d');
        $date = new DateTime($request->fecha_ingreso);
        $employee->fecha_ingreso = $date->format('Y-m-d');
        $employee->rol = $request->selectRol;
        $employee->id_manager = $request->selectManager;
        $employee->save();
        return redirect('/')->with('status', 'Empleado registrado!');
    }

    public function delete(Request $request) {
        $emp = Employee::find($request->id);
        $emp->delete();
        return redirect('empleado/consultar')->with('status', 'Empleado eliminado!');
    }

    public function update(Request $request) {
        $employee = Employee::find($request->id);
        $user = Usuario::find($request->userId);
        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
            'apellidos' => 'string|max:255',
            'cedula' => 'numeric|digits:9|unique:empleado,cedula,'.$request->id.',cedula',
            'celular' => 'numeric|digits:8',
            'email' => 'email|max:255|unique:empleado,email,'.$request->id.',cedula',
            'direccion' => 'string|max:255',
            'puesto' => 'string|max:255',
            'salario' => 'numeric',
            'fecha_ingreso' => 'date',
            'fecha_nacimiento' => 'date',
            'usuario' => 'string|max:255|unique:usuario,nombre_usuario,'.$request->userId
        ]);
        if ($validator->fails()) {
            $redirectEdit = $request->view == 1 ? '/empleado/consultar/'.$request->id : '/empleado/editar/'.$request->id;
            return redirect($redirectEdit)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        if ($request->nombre) {
            $employee->nombre = $request->nombre;
        }
        if ($request->usuario) {
            $user->nombre_usuario = $request->usuario;
            $user->save();
        }
        if ($request->apellidos) {
            $employee->apellidos = $request->apellidos;
        }
        if ($request->email) {
            $employee->email = $request->email;
        }
        if ($request->cedula) {
            $employee->cedula = $request->cedula;
        }
        if ($request->direccion) {
            $employee->direccion = $request->direccion;
        }
        if ($request->celular) {
            $employee->celular = $request->celular;
        }
        if ($request->puesto) {
            $employee->puesto = $request->puesto;
        }
        if ($request->salario) {
            $employee->salario = $request->salario;
        }
        if ($request->fecha_nacimiento) {
            $date = new DateTime($request->fecha_nacimiento);
            $employee->fecha_nacimiento = $date->format('Y-m-d');
        }
        if ($request->fecha_ingreso) {
            $date = new DateTime($request->fecha_ingreso);
            $employee->fecha_ingreso = $date->format('Y-m-d');
        }
        if ($request->selectRol ) {
            $employee->rol = $request->selectRol;
        }
        if ($request->selectManager) {
            $employee->id_manager = $request->selectManager;
        }
        $employee->save();
        if ($request->view == 1) {
            return redirect('/')->with('status', 'Datos actualizados!');
        } else {
            return redirect('empleado/consultar')->with('status', 'Empleado actualizado!');
        }
    }
}
