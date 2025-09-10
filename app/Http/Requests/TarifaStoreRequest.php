<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TarifaStoreRequest extends FormRequest
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
            "nombre"            => "required|max:50|string",//letras, espacios, ñ, U
            "hora-desde"        => "required|regex:/^\d{2}:\d{2}(?::\d{2})?$/",
            "hora-hasta"        => "required|regex:/^\d{2}:\d{2}(?::\d{2})?$/",
            "precio"            => "required|numeric|min:0",
        ];
    }

    public function messages(): array
    {
        return [
            "nombre.required"           => "El nombre es obligatorio",
            "nombre.string"             => "El nombre debe ser un texto",
            "nombre.max"                => "El nombre es demaciado largo",
            "hora_desde.required"       => "La hora desde es obligatoria",
            "hora_desde.regex"          => "El formato de la hora desde es invalido",
            "hora_hasta.required"       => "La hora hasta es obligatoria",
            "hora_hasta.regex"          => "El formato de la hora hasta es invalido",
            "precio.required"           => "El precio es obligatorio",
            "precio.numeric"            => "El precio debe ser un numero",
            "precio.min"                => "El precio debe ser mayor o igual a 0",
        ];
    }
}
