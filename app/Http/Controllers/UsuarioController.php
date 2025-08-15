<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    //
    public function index()
    {
        $usuarios = Usuario::all();
        return response()->json($usuarios, 200);
    }

    public function show($id)
    {
        return "Detalle del usuario con id: $id";
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'      => 'required|unique:usuario,username',
            'password'      => 'required',
            'rela_contacto' => 'required|exists:contacto,id',
            'rela_rol'      => 'required|exists:rol,id',
        ],
        [
            'username.required' => 'El campo username es obligatorio',
            'username.unique' => 'El campo username debe ser único',
            'password.required' => 'El campo password es obligatorio',
            'rela_contacto.required' => 'El campo rela_contacto es obligatorio',
            'rela_contacto.exists' => 'El campo rela_contacto no existe en la tabla contacto',
            'rela_rol.required' => 'El campo rela_rol es obligatorio',
            'rela_rol.exists' => 'El campo rela_rol no existe en la tabla rol',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "Error de validación",
                "errors" => $validator->errors()], 400);
        }

        $usuario = Usuario::create([
            "username"      => $request->username,
            "password"      => Hash::make($request->password),
            "rela_contacto" => $request->rela_contacto,
            "rela_rol"      => $request->rela_rol,
        ]);

        if (!$usuario) {
            return response()->json([
                "success" => false,
                'message' => 'Error al crear el usuario'], 500);
        }

        $usuario->load('contacto', 'rol');

        return response()->json([
            "success"       => true,
            "message"       => "Usuario creado correctamente",
            "usuario"       => $usuario,
        ], 201);
    }

    public function registrarUsuario(Request $request)
    {
        return response()->json([
            "success" => true,
            "usuario" => $request->all(),
        ], 200);
        $validator = Validator::make($request->all(), [
            'username'      => 'required|unique:usuario,username',
            'password'      => 'required',
            'rela_contacto' => 'required|exists:contacto,id',
            'rela_rol'      => 'required|exists:rol,id',
        ],
        [
            'username.required' => 'El campo username es obligatorio',
            'username.unique' => 'El campo username debe ser único',
            'password.required' => 'El campo password es obligatorio',
            'rela_contacto.required' => 'El campo rela_contacto es obligatorio',
            'rela_contacto.exists' => 'El campo rela_contacto no existe en la tabla contacto',
            'rela_rol.required' => 'El campo rela_rol es obligatorio',
            'rela_rol.exists' => 'El campo rela_rol no existe en la tabla rol',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "Error de validación",
                "errors" => $validator->errors()], 400);
        }

        $usuario = Usuario::create([
            "username"      => $request->username,
            "password"      => Hash::make($request->password),
            "rela_contacto" => $request->rela_contacto,
            "rela_rol"      => $request->rela_rol,
        ]);

        if (!$usuario) {
            return response()->json([
                "success" => false,
                'message' => 'Error al crear el usuario'], 500);
        }

        $usuario->load('contacto', 'rol');

        return response()->json([
            "success"       => true,
            "message"       => "Usuario creado correctamente",
            "usuario"       => $usuario,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        return "Actualizar el usuario con id: $id";
    }

    public function destroy($id)
    {
        return "Eliminar el usuario con id: $id";
    }

    public function mostrarMiPerfil()
    {
        $usuario = Usuario::with([
            'contacto.persona.sexo',
            'contacto.persona.documentos.tipoDocumento',
        ])->find(session('usuario')->id);


        $mensaje = 'No disponible';

        $persona = $usuario->contacto->persona ?? null;

        $documento = $persona?->documentos?->first();

        $data = [
            'usuario' => $usuario ?? null,
            'nombre' => $persona?->nombre ?? $mensaje,
            'apellido' => $persona?->apellido ?? $mensaje,
            'tipo_documento' => $documento?->tipoDocumento?->descripcion ?? $mensaje,
            'numero_documento' => $documento?->descripcion ?? $mensaje,
            'sexo' => $persona?->sexo?->descripcion ?? $mensaje,
            'fecha_nacimiento' => $persona?->fecha_nacimiento ?? $mensaje,
        ];
        // return response()->json($data);
        return view('auth_casero.miPerfil', $data);
    }

    public function cambiarContrasena(Request $request) {
        $passwordIngresada          = $request->password; //contraseña "actual" enviada en el form
        $passwordNueva              = $request->password_nueva;
        $confirmarPassword          = $request->confirmar_password;


        if(!$this->verificarContrasenaActual($passwordIngresada)) {
            return response()->json([
                "success" => false,
                "message" => "La contraseña ingresada no coincide con la actual",
            ], 400);
        }

        if ($passwordNueva !== $confirmarPassword) {
            return response()->json([
                "success" => false,
                "message" => "Las contraseñas nuevas no coinciden",
            ], 400);
        }

        $usuarioId = session('usuario')->id;
        $usuario = Usuario::find($usuarioId);

        if (!$usuario) {
            return response()->json([
                "success" => false,
                "message" => "Usuario no encontrado",
            ], 404);
        }

        $usuario->password = Hash::make($passwordNueva);
        $usuario->save();


        session()->flush();
        
        return redirect('/login-casero')->with([
            "success" => true,
            "message" => "Contraseña actualizada correctamente",
        ], 200);
    }

    private function verificarContrasenaActual($passwordIngresada) {
        // Obtener ID del usuario desde la sesión
        $usuarioId = session('usuario')->id;
    
        // Buscar el usuario en la base de datos
        $usuario = Usuario::find($usuarioId);
    
        // Verificar si el usuario existe y si la contraseña coincide
        if ($usuario && Hash::check($passwordIngresada, $usuario->password)) {
            return true;
        }
    
        return false;
    }
}
