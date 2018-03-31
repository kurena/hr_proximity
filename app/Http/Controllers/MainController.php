<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function show () {
        $vacations = 0;
        $permissions = 0;
        $contracts = 0;
        if (Auth::user()) {
            $idEmp = Auth::user()->id_empleado;
            $empleado = DB::select('select * from empleado where cedula = ?', [$idEmp])[0];
            if ($empleado->rol == 'administrador') {
                $vacations = DB::select('select count(*) as count from vacaciones v inner join empleado e on e.cedula=v.id_empleado where v.estado=? and e.id_manager=?', ['pendiente', $idEmp])[0]->count;
                $permissions = DB::select('select count(*) as count from ausencias a inner join empleado e on e.cedula=a.id_empleado where a.estado=? and e.id_manager=?', ['pendiente', $idEmp])[0]->count;  
                $contracts = DB::select("select count(*) as count from contratos c inner join empleado e on e.cedula=c.id_empleado where date_format(c.fecha_fin, '%m') =? and e.id_manager=? ", [date('m'), $idEmp])[0]->count; 
            }
        } else {
            $empleado = '';
            return redirect()->route('login');
        }
    	return view('main', ['empleado' => $empleado, 'vacaciones' => $vacations, 'permisos' => $permissions, 'contratos' => $contracts]);
    }
}
