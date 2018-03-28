<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use \Datetime;
use App\Permissions;
use Validator;

class PermissionsController extends Controller
{
    public function getAuthUser () {
        $idEmp = Auth::user()->id_empleado;
        $empleado = DB::select('select a.email as admin_email, a.nombre as admin_nombre, a.apellidos as admin_apellidos, e.nombre, e.apellidos, e.cedula, e.id_manager, e.fecha_ingreso, e.email  from empleado e inner join empleado a ON e.id_manager=a.cedula where e.cedula = ?', [$idEmp]);
        return $empleado;
    }

    public function showView () {
        if (Auth::user()) {
            $empleado = $this->getAuthUser()[0];
            $requestedDays = DB::select("select date_format(fecha, '%d-%m-%Y') as fecha, estado, comentarios, cant_horas from ausencias where id_empleado = ?", [$empleado->cedula]);
        } else {
            $empleado = [0 => ''];
            $admins = [0 => ''];
            return redirect()->route('login');
        }
    	return view('permissionsView', ['empleado' => $empleado, 'requestedDays' => $requestedDays]);
    }

    public function store (Request $request) {
        $validator = Validator::make($request->all(), [
            'dia' => 'required',
            'cantidad' => 'required|numeric',
            'comentarios' => 'required|string|max:300'
        ]);
        if ($validator->fails()) {
            return redirect('/permisos')
                        ->withErrors($validator)
                        ->withInput();
        }
        $permission = new Permissions;
        $date = new DateTime($request->day);
        $permission->id_empleado = $request->empleado;
        $permission->fecha = $date->format('Y-m-d');
        $permission->cant_horas = $request->cantidad;  
        $permission->estado = 'pendiente'; 
        $permission->comentarios = $request->comentarios; 
        $permission->save();  
        return redirect('/permisos')->with('status', 'Permiso de ausencia solicitado!');
             
    }

}
