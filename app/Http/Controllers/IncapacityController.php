<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use \Datetime;
use App\Incapacity;
use Validator;

class IncapacityController extends Controller
{
    public function getAuthUser () {
        $idEmp = Auth::user()->id_empleado;
        $empleado = DB::select('select a.email as admin_email, a.nombre as admin_nombre, a.apellidos as admin_apellidos, e.nombre, e.apellidos, e.cedula, e.id_manager, e.fecha_ingreso, e.email  from empleado e inner join empleado a ON e.id_manager=a.cedula where e.cedula = ?', [$idEmp]);
        return $empleado;
    }

    public function showView () {
        if (Auth::user()) {
            $empleado = $this->getAuthUser()[0];
            $activeDays = DB::select("select date_format(i.fecha_inicio, '%d-%m-%Y') as fecha_inicio, date_format(i.fecha_fin, '%d-%m-%Y') as fecha_fin, i.comentarios, e.nombre, e.apellidos from incapacidades i inner join empleado e on e.cedula=i.id_empleado", []);
            $employees = DB::select("select nombre, apellidos, cedula from empleado");
          } else {
            $empleado = [0 => ''];
            $admins = [0 => ''];
            return redirect()->route('login');
        }
    	return view('incapacityView', ['empleado' => $empleado, 'activeDays' => $activeDays, 'employees' => $employees]);
    }

    public function store (Request $request) {
      $validator = Validator::make($request->all(), [
          'fecha_inicio' => 'required|date',
          'fecha_fin' => 'required|date',
          'comentarios' => 'required|string|max:300'
      ]);
      if ($validator->fails()) {
          return redirect('/incapacidades')
                      ->withErrors($validator)
                      ->withInput();
      }
      $incapacity = new Incapacity;
      $dateStart = new DateTime($request->fecha_inicio);
      $dateEnd = new DateTime($request->fecha_fin);
      $incapacity->id_empleado = $request->selectEmployee;
      $incapacity->fecha_inicio = $dateStart->format('Y-m-d');
      $incapacity->fecha_fin = $dateEnd->format('Y-m-d');
      $incapacity->comentarios = $request->comentarios; 
      $incapacity->save();  
      return redirect('/incapacidades')->with('status', 'Incapacidad ingresada correctamente!');
           
  }

}
