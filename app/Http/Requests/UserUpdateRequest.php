<?php 

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Cambiar si querés controlar permisos
    }

    public function rules(): array
    {
        $user = $this->route('user'); // Obtenemos el User desde la ruta
        $personaDocumentoId = $user->persona->documentos->first()?->id; // Documento actual

        return [
            // Datos básicos
            'name' => ['required', 'string', 'max:40'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],

            // Roles
            'roles' => ['nullable', 'array'],
            'roles.*' => ['exists:roles,name'],

            // Datos personales
            'persona_nombre' => ['required', 'string', 'max:50'],
            'apellido' => ['required', 'string', 'max:50'],
            'tipo_documento' => ['required', 'exists:tipo_documento,id'],
            'documento' => [
                'required',
                'string',
                'max:20',
                Rule::unique('documento', 'descripcion')
                    ->where(fn($q) => $q->where('rela_tipo_documento', $this->input('tipo_documento')))
                    ->ignore($personaDocumentoId),
            ],
            'fecha_nacimiento' => ['required', 'date', 'before:today'],
            'sexo' => ['required', 'exists:sexo,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El campo nombre de usuario es obligatorio.',
            'name.max' => 'El campo nombre de usuario es muy largo.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo debe tener un formato válido.',
            'email.unique' => 'Ya existe un usuario registrado con este correo.',
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
    }
}
