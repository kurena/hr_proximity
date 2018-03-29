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
        if (Auth::user()) {
            $idEmp = Auth::user()->id_empleado;
            $empleado = DB::select('select * from empleado where cedula = ?', [$idEmp])[0];
            if ($empleado->rol = 'administrador') {
                $vacations = DB::select('select count(*) as count from vacaciones v inner join empleado e on e.cedula=v.id_empleado inner join empleado a on a.cedula = e.id_manager where v.estado=?', ['pendiente'])[0]->count;
                $permissions = DB::select('select count(*) as count from ausencias a inner join empleado e on e.cedula=a.id_empleado inner join empleado ad on ad.cedula = e.id_manager where a.estado=?', ['pendiente'])[0]->count;   
            }
        } else {
            $empleado = '';
            return redirect()->route('login');
        }
    	return view('main', ['empleado' => $empleado, 'vacaciones' => $vacations, 'permisos' => $permissions]);
    }
}
