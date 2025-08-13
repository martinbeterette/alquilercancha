<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class CrearClienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'contacto' => [
                'required',
                'max:50',
                'unique:contacto,descripcion',
                'regex:/^(\+?\d{7,15}|[^\s@]+@[^\s@]+\.[^\s@]+)$/',
            ],
            'nombre' => 'required|string|max:40',
        ];
    }

    public function messages(): array
    {
        return [
            'contacto.required' => 'El contacto es requerido',
            'contacto.max'      => 'El contacto es demaciado largo',
            'contacto.unique'   => 'Este contacto ya esta registrado a un cliente',
            'contacto.regex'    => 'El contacto debe ser valido',
            'nombre.required'   => 'El nombre es requerido',
            'nombre.string'     => 'El nombre debe ser un texto',
            'nombre.max'        => 'El nombre es demaciado largo',
        ];
    }
}
