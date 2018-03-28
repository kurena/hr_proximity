<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use \Datetime;
use App\Vacations;
use Validator;
use Mail;

class VacationsController extends Controller
{
    public function getAuthUser () {
        $idEmp = Auth::user()->id_empleado;
        $empleado = DB::select('select a.email as admin_email, a.nombre as admin_nombre, a.apellidos as admin_apellidos, e.nombre, e.apellidos, e.cedula, e.id_manager, e.fecha_ingreso, e.email  from empleado e inner join empleado a ON e.id_manager=a.cedula where e.cedula = ?', [$idEmp]);
        return $empleado;
    }

    public function showView () {
        if (Auth::user()) {
            $empleado = $this->getAuthUser()[0];
            $usedDays = DB::select('select count(*) as count from vacaciones where id_empleado = ?', [$empleado->cedula])[0];
            $requestedDays = DB::select("select date_format(fecha, '%d-%m-%Y') as fecha, estado from vacaciones where id_empleado = ?", [$empleado->cedula]);
            $admins = DB::select('select cedula, nombre, apellidos from empleado where rol = ?', ['administrador']);
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
    	return view('vacationsView', ['empleado' => $empleado, 'availableDays' => $availableDays, 'requestedDays' => $requestedDays, 'admins' => $admins]);
    }

    public function request_email(String $adminName, String $adminEmail, String $empName, String $date){
        $data = array('adminName'=>$adminName, 'employeeName' => $empName, 'day' => $date);
     
        Mail::send('mail', $data, function($message) use($adminEmail, $adminName) {
           $message->to($adminEmail, $adminName)->subject
              ('Solicitud de vacaciones');
           $message->from('kaut0894@gmail.com','Vacaciones');
        });
     }

    public function store (Request $request) {
        $validator = Validator::make($request->all(), [
            'dias' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect('/vacaciones')
                        ->withErrors($validator)
                        ->withInput();
        }
        $days = explode(",", $request->dias);
        foreach ($days as $day) {
            $vacations = new Vacations;
            $date = new DateTime($day);
            $vacations->id_empleado = $request->empleado;
            $vacations->fecha = $date->format('Y-m-d');
            $vacations->estado = 'pendiente';  
            $vacations->save();  
            $this->request_email($request->adminName, $request->adminEmail, $request->employeeName, $day);
        } 
        return redirect('/vacaciones')->with('status', 'Vacaciones solicitadas!');
             
    }

}
