<?php

namespace App\Http\Controllers\Auth;

use App\Usuario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombre_usuario' => 'required|string|max:255|unique:usuario',
            'cedula' => 'required|string|max:255',
            'contrasena' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return Usuario::create([
            'nombre_usuario' => $data['nombre_usuario'],
            'id_empleado' => $data['cedula'],
            'contrasena' => bcrypt($data['contrasena']),
        ]);
    }

    protected function showRegistrationForm() {
        if (Auth::user()) {
            $idEmp = Auth::user()->id_empleado;
            $empleado = DB::select('select * from empleado where cedula = ?', [$idEmp]);
            $emps = DB::select('select * from empleado where cedula not in (select id_empleado from usuario)');
            return view('auth.register', ['emps' => $emps, 'empleado' => $empleado[0]]); 
        }else {   
            return redirect()->route('login');
        }
    }

    public function registered($request,$user)
    {
        return redirect('/')->with('status', 'Usuario registrado!');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }
}
