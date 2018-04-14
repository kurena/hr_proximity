<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use \Datetime;
use \DateInterval;
use App\Vacations;
use Validator;

class ReportsController extends Controller
{
    private $PERIOD_DAYS = 10;

    public function getAvailableDays($empId, $fecha_ingreso) {
      $usedDays = DB::select('select count(*) as count from vacaciones where id_empleado = ? and estado in (?,?)', [$empId, 'pendiente', 'aprobado'])[0];
      $dateStart = DateTime::createFromFormat('Y-m-d', $fecha_ingreso);
      $availableDays = (date("Y") - $dateStart->format('Y')) * $this->PERIOD_DAYS;
      if (date('m') < $dateStart->format('m')) {
        $availableDays -= $this->PERIOD_DAYS;
      }
      $availableDays -= $usedDays->count;
      return $availableDays;
    }

    public function getVacationsPeriods($fecha_ingreso, $used) {
      $date = DateTime::createFromFormat('Y-m-d', $fecha_ingreso);
      $numberPeriods = date("Y") - $date->format('Y');
      $periods = [];
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
      return $periods;
    }

    public function getAuthUser () {
      $idEmp = Auth::user()->id_empleado;
      $empleado = DB::select('select a.email as admin_email, a.nombre as admin_nombre, a.apellidos as admin_apellidos, e.nombre, e.apellidos, e.cedula, e.id_manager, e.fecha_ingreso, e.email  from empleado e inner join empleado a ON e.id_manager=a.cedula where e.cedula = ?', [$idEmp]);
      return $empleado;
    }

    public function showView () {
      if (Auth::user()) {
        $empleado = $this->getAuthUser()[0];
        $employees = DB::select('select nombre, cedula, apellidos from empleado'); 
      } else {
        $empleado = [];
        $employees = [];
        return redirect()->route('login');
      }    
    	return view('reportsView', ['empleado' => $empleado, 'employees' => $employees]);
    }

    public function createEmployeeReport (Request $request) {
      if (Auth::user()) {
        $reporter = $this->getAuthUser()[0];
        $empId = $request->selectEmployee;
        $employee = DB::select("select nombre, apellidos, cedula, direccion, celular, puesto, salario, date_format(fecha_nacimiento, '%d/%m/%Y') as fecha_nacimiento, date_format(fecha_ingreso, '%d/%m/%Y') as fecha_ingreso, email from empleado where cedula=?", [$empId])[0];
        $date = date('d/m/Y');
      } else {
        $reporter = [];
        return redirect()->route('login');
      }    
      return view('employeeReport', ['reporter' => $reporter, 'creationDate' => $date, 'employee' => $employee]);
    }

    public function createVacationsReport (Request $request) {
      if (Auth::user()) {
        $reporter = $this->getAuthUser()[0];
        $empId = $request->selectEmployee;
        $usedDays = DB::select('select count(*) as count from vacaciones where id_empleado = ? and estado in (?,?)', [$empId, 'pendiente', 'aprobado'])[0];
        $employee = DB::select("select nombre, apellidos, cedula, fecha_ingreso from empleado where cedula=?", [$empId])[0];
        $days = DB::select("select date_format(fecha, '%d-%m-%Y') as f_fecha from vacaciones where id_empleado = ? and estado = ? order by fecha desc", [$empId, 'aprobado']);
        $date = date('d/m/Y');
        $availableDays = $this->getAvailableDays($empId, $employee->fecha_ingreso);
        $periods = $this->getVacationsPeriods($employee->fecha_ingreso, $usedDays->count);
      } else {
        $reporter = [];
        return redirect()->route('login');
      }    
      return view('vacationsReport', ['reporter' => $reporter, 'creationDate' => $date, 'employee' => $employee, 'days' => $days, 'availableDays' => $availableDays, 'periods' => $periods]);
    }

    public function createPermissionsReport (Request $request) {
      if (Auth::user()) {
        $reporter = $this->getAuthUser()[0];
        $empId = $request->selectEmployee;
        $employee = DB::select("select nombre, apellidos, cedula, fecha_ingreso, salario from empleado where cedula=?", [$empId])[0];
        $days = DB::select("select date_format(fecha, '%d-%m-%Y') as f_fecha, reposicion, cant_horas from ausencias where id_empleado = ? and estado = ? order by fecha desc", [$empId, 'aprobado']);
        $date = date('d/m/Y');
        foreach ($days as $day) {
          $affect = 0;
          if ($day->reposicion == 0) {
              $affect = ($employee->salario / 30) * $day->cant_horas;
          }    
          $day->afectacion = $affect;
        }
      } else {
        $reporter = [];
        return redirect()->route('login');
      }    
      return view('permissionsReport', ['reporter' => $reporter, 'creationDate' => $date, 'employee' => $employee, 'days' => $days]);
    }

    public function createIncapacityReport (Request $request) {
      if (Auth::user()) {
        $reporter = $this->getAuthUser()[0];
        $empId = $request->selectEmployee;
        $employee = DB::select("select nombre, apellidos, cedula, fecha_ingreso, salario from empleado where cedula=?", [$empId])[0];
        $days = DB::select("select date_format(fecha_inicio, '%d-%m-%Y') as f_fecha_i, date_format(fecha_fin, '%d-%m-%Y') as f_fecha_f from incapacidades where id_empleado = ? order by fecha_inicio desc", [$empId]);
        $date = date('d/m/Y');
        foreach ($days as $day) {
          $salDay = $employee->salario / 30;
          $affect1 =  $salDay * 0.50;
          $affect2 =  $salDay * 0.60;
          $day->afectacionCCSS1 = $affect1;
          $day->afectacionCCSS2 = $affect2;
          $day->afectacionPatrono = $affect1;
        }
      } else {
        $reporter = [];
        return redirect()->route('login');
      }    
      return view('incapacityReport', ['reporter' => $reporter, 'creationDate' => $date, 'employee' => $employee, 'days' => $days]);
    }

    public function createContractsReport (Request $request) {
      if (Auth::user()) {
        $reporter = $this->getAuthUser()[0];
        $contractId = $request->id;
        $contract = DB::select("select e.nombre, e.apellidos, c.nombre as nombre_contrato, c.tipo, c.forma_pago, c.monto,  date_format(fecha_inicio, '%d/%m/%Y') as fecha_inicio, date_format(fecha_fin, '%d/%m/%Y') as fecha_fin from contratos c inner join empleado e on c.id_empleado = e.cedula where id=?", [$contractId])[0];
        $calculations = DB::select("select date_format(fecha, '%d/%m/%Y') as fecha_f, monto from contratos_comprobacion where id_contrato = ? order by fecha desc", [$contractId]);
        $date = date('d/m/Y');
        $total = 0;
        foreach ($calculations as $calculation) {
          $total += $calculation->monto;  
        }
      } else {
        $reporter = [];
        return redirect()->route('login');
      }    
      return view('contractsReport', ['reporter' => $reporter, 'creationDate' => $date, 'contract' => $contract, 'calculations' => $calculations, 'total' => $total]);
    }

    public function createTravelExpenseReport (Request $request) {
      if (Auth::user()) {
        $reporter = $this->getAuthUser()[0];
        $expenseId = $request->id;
        $expense = DB::select("select e.nombre, e.apellidos, v.tipo, v.total, v.descripcion, date_format(v.fecha, '%d/%m/%Y') as fecha from viaticos v inner join empleado e on v.id_empleado = e.cedula where id=?", [$expenseId])[0];
        $calculations = DB::select("select date_format(fecha, '%d/%m/%Y') as fecha_f, monto, tipo, descripcion from viaticos_comprobacion where id_viatico = ? order by fecha desc", [$expenseId]);
        $date = date('d/m/Y');
        $total = 0;
        foreach ($calculations as $calculation) {
          $total += $calculation->monto;  
        }
      } else {
        $reporter = [];
        return redirect()->route('login');
      }    
      return view('travelExpenseReport', ['reporter' => $reporter, 'creationDate' => $date, 'expense' => $expense, 'calculations' => $calculations, 'total' => $total]);
    }

}
