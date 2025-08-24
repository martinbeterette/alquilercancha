<?php

namespace App\Http\Controllers;

use App\Models\Sexo;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;
use App\Models\User; 
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Persona;


class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get(); // trae todos los usuarios con roles
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles              = Role::all(); // todos los roles disponibles
        $tipos_documento    = TipoDocumento::all();
        $sexos              = Sexo::all();
        return view('users.create', compact('roles','tipos_documento','sexos'));
    }

    public function store(Request $request)
    {
        $this->validarFormularioUsuario($request);
        // return "todo correcto";

        //creamos la persona
        $persona = Persona::create([
            'nombre'                => $request->persona_nombre,
            'apellido'              => $request->apellido,
            'fecha_nacimiento'      => $request->fecha_nacimiento,
            'rela_sexo'             => $request->sexo,
        ]);

        //creamos el documento
        $persona->documentos()->create([
            'rela_tipo_documento' => $request->tipo_documento,
            'descripcion'         => $request->documento,
        ]);

        // Crear usuario
        $user = $persona->users()->create([
            'name'              => $request->name,
            'email'             => $request->email,
            'email_verified_at' => now(),
            'password'          => Hash::make($request->password),
        ]);

        // Asignar roles
        if ($request->roles) {
            $user->syncRoles($request->roles);
        }

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente');
    }

    public function edit(User $user)
    {
        $roles              = Role::all(); // todos los roles disponibles
        $tipos_documento    = TipoDocumento::all();
        $sexos              = Sexo::all();
        $documento          = $user->persona->documentos->first(); // Asumiendo que un usuario tiene un documento
        $persona            = $user->persona;
        return view('users.edit', compact('user', 'roles', 'tipos_documento', 'sexos', 'documento', 'persona'));
    }

    public function update(Request $request, User $user)
    {
        $this->validarFormularioUsuario($request, $user);

        $arrayUser = [
            "name" => $request->name,
            "email" => $request->email,
        ];
        $arrayPersona = [
            "nombre" => $request->persona_nombre,
            "apellido" => $request->apellido,
            "rela_sexo" => $request->sexo,
            "fecha_nacimiento" => $request->fecha_nacimiento,
        ];

        $arrayDocumento = [
            "rela_tipo_documento" => $request->tipo_documento,
            "descripcion" => $request->documento,
        ];
        // Si el usuario escribió una contraseña, la actualizamos
        if ($request->filled('password')) {
            $arrayUser['password'] = Hash::make($request->password);
        }
        return response()->json(compact('arrayUser','arrayPersona','arrayDocumento'));

        $user->update($arrayUser);
        $user->persona->update($arrayPersona);
        $user->persona->documentos->first()?->update($arrayDocumento); 
        $user->syncRoles($request->roles ?? []); 

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }

    private function validarFormularioUsuario(Request $request, ?User $user = null)
    {
        $userId = is_null($user) ? null : $user->id;
        $passwordRules = $userId
            ? ['nullable', 'string', 'min:6', 'confirmed'] // update
            : ['required', 'string', 'min:6', 'confirmed']; // store

        // Email condicional
        $emailRules = $userId
            ? [Rule::unique('users', 'email')->ignore($userId)]
            : ['unique:users,email'];
            
            // Documento condicional
            $documentoRules = $userId
            ? [
                Rule::unique('documento', 'descripcion')
                ->where(fn($q) => $q->where('rela_tipo_documento', $request->tipo_documento))
                ->ignore($user->persona->documentos->first()?->id) // ignora el documento actual
                ]
                : [
                    Rule::unique('documento', 'descripcion')
                    ->where(fn($q) => $q->where('rela_tipo_documento', $request->tipo_documento))
                ];

        $emailRules[] = ['email', 'required'];
        $documentoRules[] = ['required', 'string', 'max:20'];

        // Reglas finales
        $rules = [
            // Datos básicos
            'name' => ['required', 'string', 'max:40'],
            'email' => $emailRules,
            'password' => $passwordRules,

            // Roles
            'roles' => ['nullable', 'array'],
            'roles.*' => ['exists:roles,name'],

            // Datos personales
            'persona_nombre' => ['required', 'string', 'max:50'],
            'apellido' => ['required', 'string', 'max:50'],
            'tipo_documento' => ['required', 'exists:tipo_documento,id'],
            'documento' => $documentoRules,
            'fecha_nacimiento' => ['required', 'date', 'before:today'],
            'sexo' => ['required', 'exists:sexo,id'], 
        ];
        $messages = [
            'name.required' => 'El campo nombre de usuario es obligatorio.',
            'name.max' => 'El campo nombre de usuario es muy largo.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo debe tener un formato válido.',
            'email.unique' => 'Ya existe un usuario registrado con este correo.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'persona_nombre.required' => 'El nombre de la persona es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'tipo_documento.required' => 'Debe seleccionar un tipo de documento.',
            'tipo_documento.exists' => 'El tipo de documento seleccionado no es válido.',
            'documento.required' => 'El número de documento es obligatorio.',
            'documento.unique' => 'Ya existe un usuario con ese documento y tipo.',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
            'sexo.required' => 'Debe seleccionar el sexo.',
            'sexo.exists' => 'El sexo seleccionado no es válido.',
        ];


        $request->validate($rules, $messages);
    }

}
