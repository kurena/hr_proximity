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
            $expenses = DB::select("select date_format(v.fecha, '%d-%m-%Y') as fecha, v.tipo, v.descripcion, v.total, v.id, e.nombre, e.apellidos from viaticos v inner join empleado e on e.cedula=v.id_empleado", []);
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
            if ($empleado->cedula != $empId) {
                return redirect('/');    
            }
            $expenses = DB::select("select date_format(v.fecha, '%d-%m-%Y') as fecha, v.id, 
            v.tipo, v.descripcion, v.total from viaticos v inner join empleado e on 
            e.cedula=v.id_empleado where e.cedula=?", [$empId]);
            if (count($expenses) == 0) {
                return redirect('/')->with('error','No existen viáticos asignados'); 
            }
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
            $total = DB::select("select total from viaticos where id=?",[$expenseId]);
            if (!$total) {
                return redirect('/');    
            }
            $expenses = DB::select("select date_format(v.fecha, '%d-%m-%Y') as fecha, v.tipo, v.descripcion, v.monto, e.total, v.id from viaticos_comprobacion v inner join viaticos e on e.id=v.id_viatico where v.id_viatico=?", [$expenseId]);
        } else {
            $empleado = [0 => ''];
            return redirect()->route('login');
        }
        $reported = 0;
        foreach($expenses as $expense) {
            $reported += $expense->monto;
        } 
    	return view('travelExpenseCalculationView', ['total'=>$total[0],'reported' => $reported, 'empleado' => $empleado, 'expenses' => $expenses, 'expenseId' => $expenseId]);    
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
        return redirect('/viaticos/comprobacion/'.$expenseId)->with('status', 'Comprobación ingresada correctamente!');
             
    }

    public function delete(Request $request) {
        $contract = TravelExpense::find($request->id);
        $contract->delete();
        return redirect('/viaticos')->with('status', 'Viatico eliminado!');
    }

    public function deleteCalculation(Request $request) {
        $contract = TravelExpenseCalculation::find($request->id);
        $contract->delete();
        return redirect('/viaticos/comprobacion/'.$request->expenseId)->with('status', 'Comprobación eliminada!');
    }

    public function getCalculationInformation(Request $request) {
        if (Auth::user()) {
            $calculationId = $request->id;
            $calculation = DB::select("select date_format(fecha, '%d-%m-%Y') as fecha, tipo, monto, id, descripcion from viaticos_comprobacion where id=?", [$calculationId])[0];
          } else {
            $empleado = [0 => ''];
            $admins = [0 => ''];
            return redirect()->route('login');
        }
        return ['calculation' => $calculation];
    }

    public function getTravelExpenseInformation(Request $request) {
        if (Auth::user()) {
            $expenseId = $request->id;
            $expense = DB::select("select tipo, total, id, descripcion, id_empleado from viaticos where id=?", [$expenseId])[0];
          } else {
            $empleado = [0 => ''];
            $admins = [0 => ''];
            return redirect()->route('login');
        }
        return ['expense' => $expense];
    }

    public function updateTravelExpense(Request $request) {
        $validator = Validator::make($request->all(), [
            'descripcion' => 'required|string|max:300',
            'monto' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return redirect('/viaticos')
                        ->withErrors($validator)
                        ->withInput();
        }
        $expense = TravelExpense::find($request->id);
        $expense->id_empleado = $request->selectEmployee;
        $expense->descripcion = $request->descripcion; 
        $expense->total = $request->monto; 
        $expense->tipo = $request->selectType; 
        $expense->save();  
        return redirect('/viaticos')->with('status', 'Viático modificado!');
    }

    public function updateCalculation(Request $request) {
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
        $calculation = TravelExpenseCalculation::find($request->id);
        $date = new DateTime($request->fecha);
        $calculation->fecha = $date->format('Y-m-d');
        $calculation->descripcion = $request->descripcion; 
        $calculation->monto = $request->monto; 
        $calculation->tipo = $request->selectType; 
        $calculation->save();  
        return redirect('/viaticos/comprobacion/'.$expenseId)->with('status', 'Comprobación modificada correctamente!');
    }

    public function getExpenseInformation(Request $request) {
        if (Auth::user()) {
            $empId = $request->id;
            $expense = DB::select("select date_format(fecha, '%d-%m-%Y') as fecha, tipo, total, id from viaticos where id_empleado=?", [$empId]);
          } else {
            $empleado = [0 => ''];
            $admins = [0 => ''];
            return redirect()->route('login');
        }
        return ['expenses' => $expense];    
    }

}
