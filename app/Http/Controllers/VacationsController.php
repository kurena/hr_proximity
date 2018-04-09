<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use \Datetime;
use \DateInterval;
use App\Vacations;
use Validator;
use Mail;

class VacationsController extends Controller
{
    private $PERIOD_DAYS = 10;

    public function getAvailableDays() {

    }
    
    public function getAuthUser () {
        $idEmp = Auth::user()->id_empleado;
        $empleado = DB::select('select a.email as admin_email, a.nombre as admin_nombre, a.apellidos as admin_apellidos, e.nombre, e.apellidos, e.cedula, e.id_manager, e.fecha_ingreso, e.email  from empleado e inner join empleado a ON e.id_manager=a.cedula where e.cedula = ?', [$idEmp]);
        return $empleado;
    }

    public function showView () {
        if (Auth::user()) {
            $empleado = $this->getAuthUser()[0];
            $usedDays = DB::select('select count(*) as count from vacaciones where id_empleado = ? and estado in (?,?)', [$empleado->cedula, 'pendiente', 'aprobado'])[0];
            $requestedDays = DB::select("select date_format(fecha, '%d-%m-%Y') as fecha, estado from vacaciones where id_empleado = ?", [$empleado->cedula]);
            $admins = DB::select('select cedula, nombre, apellidos from empleado where rol = ?', ['administrador']);
            $date = DateTime::createFromFormat('Y-m-d', $empleado->fecha_ingreso);
            $availableDays = (date("Y") - $date->format('Y')) * $this->PERIOD_DAYS;
            if (date('m') < $date->format('m')) {
              $availableDays -= $this->PERIOD_DAYS;
            }
            $availableDays -= $usedDays->count;
            $numberPeriods = date("Y") - $date->format('Y');
            $periods = [];
            $used = $usedDays->count;
            for ($i = 0 ; $i < $numberPeriods; $i++) {
                if ($this->PERIOD_DAYS >= $used) {
                    $availablePeriodDays = $this->PERIOD_DAYS - $used;   
                    $used = 0; 
                }
                if ($this->PERIOD_DAYS < $used) {
                    $availablePeriodDays = 0;
                    $used = $used - $this->PERIOD_DAYS;
                }
                if ($i == ($numberPeriods - 1) && date('m') < $date->format('m')) {
                    $availablePeriodDays = 0;
                }
                array_push($periods, ['start' => $date->format('d-m-Y'), 'end' => $date->add(new DateInterval('P1Y'))->format('d-m-Y'), 'days' => $availablePeriodDays]);
            }
        } else {
            $empleado = [0 => ''];
            $admins = [0 => ''];
            return redirect()->route('login');
        }
    	return view('vacationsView', ['empleado' => $empleado, 'availableDays' => $availableDays, 'requestedDays' => $requestedDays, 'admins' => $admins, 'periods' => $periods]);
    }

    public function showApprovalView () {
        if (Auth::user()) {
            $empleado = $this->getAuthUser()[0];
            $requestedDays = DB::select("select date_format(v.fecha, '%d-%m-%Y') as fecha, v.estado, v.id, e.nombre, e.apellidos from vacaciones v inner join empleado e on  e.cedula=v.id_empleado inner join empleado a on a.cedula = e.id_manager where e.id_manager=? and v.estado=?", [$empleado->cedula, 'pendiente']);
            $approvedDays = DB::select("select date_format(v.fecha, '%d-%m-%Y') as fecha, v.estado, v.id, e.nombre, e.apellidos from vacaciones v inner join empleado e on  e.cedula=v.id_empleado inner join empleado a on a.cedula = e.id_manager where e.id_manager=? and v.estado in (?,?) ", [$empleado->cedula, 'aprobado', 'no aprobado']);
        } else {
            $empleado = [0 => ''];
            return redirect()->route('login');
        }
    	return view('vacationsApproval', ['empleado' => $empleado, 'requestedDays' => $requestedDays, 'approvedDays' =>$approvedDays]);    
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
        if ($request->availableDays < count($days)) {
            return redirect('/vacaciones')->with('error', 'Días disponibles de vacaciones insuficientes para realizar la solicitud!');
        }
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

    public function updateStatus (Request $request) {
        $days = $request->id;
        foreach ($days as $day) {
            $vacation = Vacations::find($day);
            $status = $request['group'.$day];
            $vacation->estado = $status;
            $vacation->save();    
        }
        return redirect('vacaciones/aprobar')->with('status', 'Estado de vacaciones actualizado!');
    } 

}
