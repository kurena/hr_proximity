<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function show () {
        if (Auth::user()) {
            $idEmp = Auth::user()->id_empleado;
            $empleado = DB::select('select * from empleado where cedula = ?', [$idEmp]);
        } else {
            $empleado = [0 => ''];
        }
    	return view('main', ['empleado' => $empleado[0]]);
    }
}
