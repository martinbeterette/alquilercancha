<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use App\Models\Persona;
use App\Models\Usuario;
use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use stdClass;

class AuthController extends Controller
{
    //
    public function showLoginForm()
    {
        return view('auth_casero/login_casero');
    }

    public function showRegisterForm()
    {
        return view('auth_casero/register_casero');
    }

    
    public function recibirFormularioRegistro(Request $request)
    {
        // Validar datos
        $validator = $this->validateFormRegister($request);
        if ($validator->fails()) {
            return $this->redirectResponse(
                'formulario-registro', 
                false, 
                'Error en la validación de los datos',
                $validator->errors()->all()
            );
        }

        DB::beginTransaction();
        try{
            //creamos la persona, usaremos el id para crear el contacto
            $persona = $this->createPersona($request);

            //creamos el documento
            $this->createDocumento($request, $persona);

            //creamos el contacto, usaremos el id para crear el usuario
            $contacto = $this->createContacto($request, $persona);

            //creamos el usuario, conservamos el usuario por las dudas
            $usuario = $this->createUsuario($request, $contacto);

            //si todo sale bien, hacemos commit
            DB::commit();

            //si todo sale bien, redirigimos al login
            return $this->redirectResponse(
                '/login-casero', 
                true, 
                'Usuario creado correctamente'
            );

        }catch(\Exception $e){
            //si algo sale mal, hacemos rollback
            DB::rollback();
            
            return $this->redirectResponse(
                '/formulario-registro', 
                false, 
                'Error al crear el usuario',
                [$e->getMessage()]
            );
        }

    }

    public function login(Request $request)
    {
        // Validar datos
        $validator = Validator::make($request->all(), [
            'email'         => 'required|email|max:50',
            'password'      => 'required|min:8|max:50'
        ],
        [
            'email.required'      => 'El email es requerido',
            'email.email'         => 'El email debe ser un correo electrónico',
            'email.max'           => 'El email debe tener máximo 50 caracteres',
            'password.required' => 'La contraseña es requerida',
            'password.min'      => 'La contraseña debe tener mínimo 8 caracteres',
            'password.max'      => 'La contraseña debe tener máximo 50 caracteres',
        ]);
    
        if ($validator->fails()) {
            $data = [
                "message" => "Error en la validación de los datos",
                "errors"  => $validator->errors()->all(),
                "success" => false,
            ];

            // return response()->json($data, 400);
            return redirect()->route('login.casero')->with($data);
        }
    
        // Verificar si el usuario existe y la contraseña es correcta
        $user = $this->authenticate($request);

        if (!$user) {
            $data = [
                "message" => "Credenciales incorrectas o el usuario no existe",
                "success" => false,
                "status"  => 401,
            ];

            // return response()->view('auth/credencialesIncorrectas', compact('data'), 401);
            return redirect()->route('login.casero')->with($data);
        }
    
        //iniciar la sesion
        session(["usuario" => $user]);

        return redirect('/home');

    }

    public function logout()
    {
        session()->flush();
        return $this->redirectResponse('/login-casero', true, "Sesion cerrada exitosamente");
    }

    private function authenticate(Request $request) {
        // Buscar el usuario por email
        $user = Usuario::with('contacto')
            ->whereHas('contacto', function ($query) use ($request) {
                $query->where('descripcion', $request->email);
            })
            ->first();
            
        if (!$user) {
            return null;
        }

        if (Hash::check($request->password, $user->password)) {
            return $user;
        } else {
            return null;
        }
    }

    private function validateFormRegister(Request $request)
    {
        return Validator::make($request->all(), [
            'username'          => 'required|unique:usuario,username',
            'password'          => 'required|min:8|max:50',
            'email'             => 'required|email|max:50|unique:contacto,descripcion',
            'nombre'            => 'required|max:50',
            'apellido'          => 'required|max:50',
            'documento'         => 'required|string|max:50',
            'tipo_documento'    => 'required|exists:tipo_documento,id|integer',
            'fecha_nacimiento'  => 'required|date',
            'sexo'              => 'required|exists:sexo,id|integer',
        ],
        [
            'username.required'         => 'El campo username es obligatorio',
            'username.unique'           => 'El campo username debe ser único',
            'password.required'         => 'La contraseña es requerida',
            'password.min'              => 'La contraseña debe tener mínimo 8 caracteres',
            'password.max'              => 'La contraseña debe tener máximo 50 caracteres',
            'email.required'            => 'El email es requerido',
            'email.email'               => 'El email debe ser un correo electrónico',
            'email.max'                 => 'El email debe tener máximo 50 caracteres',
            'email.unique'              => 'El email debe ser único',
            'nombre.required'           => 'El nombre es requerido',
            'nombre.max'                => 'El nombre debe tener máximo 50 caracteres',
            'apellido.required'         => 'El apellido es requerido',
            'apellido.max'              => 'El apellido debe tener máximo 50 caracteres',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es requerida',
            'fecha_nacimiento.date'     => 'La fecha de nacimiento debe ser una fecha válida',
            'sexo.required'             => 'El sexo es requerido',
            'sexo.exists'               => 'El sexo no existe en la tabla sexo',
            'sexo.integer'              => 'El sexo debe ser un número entero',
            'documento.required'        => 'El documento es requerido',
            'documento.string'          => 'El documento debe ser una cadena de texto',
            'documento.max'             => 'El documento debe tener máximo 50 caracteres',
            'tipo_documento.required'   => 'El tipo de documento es requerido',
            'tipo_documento.exists'     => 'El tipo de documento no existe en la tabla tipo_documento',
            'tipo_documento.integer'    => 'El tipo de documento debe ser un número entero',
            // Otros mensajes de error...
        ]);
    }

    private function redirectResponse($url, $success, $message, $errors = [])
    {
        return redirect($url)->with([
            "success" => $success,
            "message" => $message,
            "errors"  => $errors,
        ]);
    }

    private function createPersona(Request $request)
    {
        return Persona::create([
            'nombre'            => $request->nombre,
            'apellido'          => $request->apellido,
            'documento'         => $request->documento,
            'tipo_documento_id' => $request->tipo_documento,
            'fecha_nacimiento'  => $request->fecha_nacimiento,
            'rela_sexo'         => $request->sexo,
        ]);
    }

    private function createDocumento(Request $request, $persona)
    {
        return Documento::create([
            'descripcion'           => $request->documento,
            'rela_tipo_documento'   => $request->tipo_documento,
            'rela_persona'          => $persona->id,
        ]);
    }

    private function createContacto(Request $request, $persona)
    {
        return Contacto::create([
            'descripcion'           => $request->email,
            'rela_tipo_contacto'    => 1, // deberia ser elegible, y no hardcodeado
            'rela_persona'          => $persona->id,
        ]);
    }

    private function createUsuario(Request $request, $contacto)
    {
        return Usuario::create([
            'username'             => $request->username,
            'password'             => Hash::make($request->password),
            'rela_contacto'        => $contacto->id,
            'rela_rol'             => 2, // deberia ser elegible, y no hardcodeado
        ]);
    }
    
}
