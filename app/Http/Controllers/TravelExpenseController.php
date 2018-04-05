<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use \Datetime;
use App\TravelExpense;
use App\TravelExpenseCalculation;
use Validator;

class TravelExpenseController extends Controller
{
    public function getAuthUser () {
        $idEmp = Auth::user()->id_empleado;
        $empleado = DB::select('select a.email as admin_email, a.nombre as admin_nombre, a.apellidos as admin_apellidos, e.nombre, e.apellidos, e.cedula, e.id_manager, e.fecha_ingreso, e.email  from empleado e inner join empleado a ON e.id_manager=a.cedula where e.cedula = ?', [$idEmp]);
        return $empleado;
    }

    public function showView () {
        if (Auth::user()) {
            $empleado = $this->getAuthUser()[0];
            $expenses = DB::select("select date_format(v.fecha, '%d-%m-%Y') as fecha, v.tipo, v.descripcion, v.total, e.nombre, e.apellidos from viaticos v inner join empleado e on e.cedula=v.id_empleado", []);
            $employees = DB::select("select nombre, apellidos, cedula from empleado");
            $actualDay = date('d-m-Y');
          } else {
            $empleado = [0 => ''];
            $admins = [0 => ''];
            return redirect()->route('login');
        }
    	return view('travelExpenseView', ['empleado' => $empleado, 'expenses' => $expenses, 'employees' => $employees, 'actualDay' => $actualDay]);
    }

    public function showEmployeeView (Request $request) {
        if (Auth::user()) {
            $empleado = $this->getAuthUser()[0];
            $empId = $request->id;
            $expenses = DB::select("select date_format(v.fecha, '%d-%m-%Y') as fecha, v.id, 
            v.tipo, v.descripcion, v.total from viaticos v inner join empleado e on 
            e.cedula=v.id_empleado where e.cedula=?", [$empId]);
          } else {
            $empleado = [0 => ''];
            return redirect()->route('login');
        }
    	return view('travelExpenseEmployeeView', ['empleado' => $empleado, 'expenses' => $expenses]);
    }

    public function showCalculationView(Request $request) {
        if (Auth::user()) {
            $empleado = $this->getAuthUser()[0];
            $expenseId = $request->id;
            $expenses = DB::select("select date_format(v.fecha, '%d-%m-%Y') as fecha, v.tipo, v.descripcion, v.monto, e.total from viaticos_comprobacion v inner join viaticos e on e.id=v.id_viatico where v.id_viatico=?", [$expenseId]);
        } else {
            $empleado = [0 => ''];
            return redirect()->route('login');
        }
        $reported = 0;
        foreach($expenses as $expense) {
            $reported += $expense->monto;
        } 
    	return view('travelExpenseCalculationView', ['reported' => $reported, 'empleado' => $empleado, 'expenses' => $expenses, 'expenseId' => $expenseId]);    
    }

    public function store (Request $request) {
      $validator = Validator::make($request->all(), [
          'descripcion' => 'required|string|max:300',
          'monto' => 'required|numeric'
      ]);
      if ($validator->fails()) {
          return redirect('/viaticos')
                      ->withErrors($validator)
                      ->withInput();
      }
      $expense = new TravelExpense;
      $expense->id_empleado = $request->selectEmployee;
      $expense->fecha = date('Y-m-d');
      $expense->descripcion = $request->descripcion; 
      $expense->total = $request->monto; 
      $expense->tipo = $request->selectType; 
      $expense->save();  
      return redirect('/viaticos')->with('status', 'Viático ingresado correctamente!');
           
    }

    public function storeCalculation (Request $request) {
        $expenseId = $request->expenseId;
        $validator = Validator::make($request->all(), [
            'descripcion' => 'required|string|max:300',
            'fecha' => 'required|date',
            'monto' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return redirect('/viaticos/comprobacion/'.$expenseId)
                        ->withErrors($validator)
                        ->withInput();
        }
        $calculation = new TravelExpenseCalculation;
        $calculation->id_viatico = $expenseId;
        $date = new DateTime($request->fecha);
        $calculation->fecha = $date->format('Y-m-d');
        $calculation->descripcion = $request->descripcion; 
        $calculation->monto = $request->monto; 
        $calculation->tipo = $request->selectType; 
        $calculation->save();  
        return redirect('/viaticos/comprobacion/'.$expenseId)->with('status', 'Comprobación ingresada 
        correctamente!');
             
    }

}