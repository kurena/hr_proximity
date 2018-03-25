<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use \Datetime;
//se App\Vacations;
use Validator;

class VacationsController extends Controller
{
    public function getAuthUser () {
        $idEmp = Auth::user()->id_empleado;
        $empleado = DB::select('select * from empleado where cedula = ?', [$idEmp]);
        return $empleado;
    }

    public function showView () {
        if (Auth::user()) {
            $empleado = $this->getAuthUser()[0];
            $usedDays = DB::select('select count(*) as count from vacaciones where id_empleado = ?', [$empleado->cedula])[0];
            $date = DateTime::createFromFormat('Y-m-d', $empleado->fecha_ingreso);
            $availableDays = (date("Y") - $date->format('Y')) * 10;
            if (date('m') < $date->format('m')) {
              $availableDays -= 10;
            }
            $availableDays -= $usedDays->count;
        } else {
            $empleado = [0 => ''];
            $admins = [0 => ''];
            return redirect()->route('login');
        }
    	return view('vacationsView', ['empleado' => $empleado, 'availableDays' => $availableDays]);
    }

}
