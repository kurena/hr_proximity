<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use \Datetime;
use App\Contracts;
use App\ContractsCalculation;
use Validator;

class ContractsController extends Controller
{
    public function getAuthUser () {
        $idEmp = Auth::user()->id_empleado;
        $empleado = DB::select('select a.email as admin_email, a.nombre as admin_nombre, a.apellidos as admin_apellidos, e.nombre, e.apellidos, e.cedula, e.id_manager, e.fecha_ingreso, e.email  from empleado e inner join empleado a ON e.id_manager=a.cedula where e.cedula = ?', [$idEmp]);
        return $empleado;
    }

    public function showView () {
        if (Auth::user()) {
            $empleado = $this->getAuthUser()[0];
            $contracts = DB::select("select date_format(c.fecha_inicio, '%d-%m-%Y') as fecha_inicio, date_format(c.fecha_fin, '%d-%m-%Y') as fecha_fin, c.tipo, c.nombre as nombre_contrato, c.id, c.forma_pago, c.monto, c.multa, e.nombre, e.apellidos from contratos c inner join empleado e on e.cedula=c.id_empleado", []);
            $employees = DB::select("select nombre, apellidos, cedula from empleado");
            $actualDay = date('d-m-Y');
          } else {
            $empleado = [0 => ''];
            $admins = [0 => ''];
            return redirect()->route('login');
        }
    	return view('contractsView', ['empleado' => $empleado, 'contracts' => $contracts, 'employees' => $employees]);
    }

    public function showCalculationView(Request $request) {
        if (Auth::user()) {
            $empleado = $this->getAuthUser()[0];
            $contractId = $request->id;
            $contracts = DB::select("select date_format(cc.fecha, '%d-%m-%Y') as fecha, cc.monto from contratos_comprobacion cc inner join contratos c on c.id=cc.id_contrato where cc.id_contrato=?", [$contractId]);
        } else {
            $empleado = [0 => ''];
            return redirect()->route('login');
        }
    	return view('contractsCalculationView', ['empleado' => $empleado, 'contracts' => $contracts, 'contractId' => $contractId]);    
    }

    public function store (Request $request) {
      $validator = Validator::make($request->all(), [
          'nombre_contrato' => 'required|string|max:50',
          'fecha_inicio' => 'required|date',
          'multa' => 'required|numeric',
          'monto' => 'required|numeric'
      ]);
      if ($validator->fails()) {
          return redirect('/contratos')
                      ->withErrors($validator)
                      ->withInput();
      }
      $contract = new Contracts;
      $contract->id_empleado = $request->selectEmployee;
      $date = new DateTime($request->fecha_inicio);
      $contract->fecha_inicio = $date->format('Y-m-d');
      if ($request->fecha_fin && !empty($request->fecha_fin) ) {
        $date = new DateTime($request->fecha_fin);
        $contract->fecha_fin = $date->format('Y-m-d');
      }
      $contract->nombre = $request->nombre_contrato; 
      $contract->monto = $request->monto; 
      $contract->tipo = $request->selectType; 
      $contract->forma_pago = $request->selectPayType; 
      $contract->multa = $request->multa; 
      $contract->save();  
      return redirect('/contratos')->with('status', 'Contrato ingresado correctamente!');
           
    }

    public function storeCalculation (Request $request) {
        $contractId = $request->contractId;
        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date',
            'monto' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return redirect('/contratos/comprobacion/'.$contractId)
                        ->withErrors($validator)
                        ->withInput();
        }
        $calculation = new ContractsCalculation;
        $calculation->id_contrato = $contractId;
        $date = new DateTime($request->fecha);
        $calculation->fecha = $date->format('Y-m-d');
        $calculation->monto = $request->monto; 
        $calculation->save();  
        return redirect('/contratos/comprobacion/'.$contractId)->with('status', 'Comprobación ingresada correctamente!');
             
    }

}
