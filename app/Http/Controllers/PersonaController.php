<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonaController extends Controller
{
    //

    public function index(Request $request)
    {
        $personas = Persona::paginate(1);

        if ($request->wantsJson()) {
            return response()->json($personas);
        } else {
            return view('personas_index', compact('personas'));
        }
    }

    public function indexApi(Request $request)
    {
        //iniciamos el query y filtro
        $query  = Persona::where('activo', 1);
        $filtro = $request->filtro ?? null;
        
        //si el filtro no es vacio, lo aplicamos
        if(!empty($filtro)){
            $campos = ["nombre", "apellido", "fecha_nacimiento"];
            $query->where(function($q) use ($filtro, $campos) {
                foreach ($campos as $campo) {
                    $q->orWhere($campo, 'LIKE', "%$filtro%");
                }
            });
        }

        //tomamos el Request y calculos del paginado
        $paginaActual       = $request->page ?? 1;
        $registrosPorPagina = $request->registros_por_pagina ?? 10;
        $offset             = ($paginaActual - 1) * $registrosPorPagina;
        $totalPersonas      = $query->get()->count();
        $totalPaginas       = ceil($totalPersonas / $registrosPorPagina);
        

        
        //ejecutamos el query
        $personas = $query
            ->offset($offset)
            ->limit($registrosPorPagina)
            ->orderBy('nombre', 'asc')
            ->get();

        $data = (object)[
            "data"              => $personas,
            "total_registros"   => $totalPersonas,
            "pagina"            => $paginaActual,
            "total_paginas"     => $totalPaginas,
        ];
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'            => 'required|string',
            'apellido'          => 'required|string',
            'fecha_nacimiento'  => 'required|date',
        ], [
            'nombre.required'           => 'El nombre es requerido',
            'apellido.required'         => 'El apellido es requerido',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es requerida',
            'fecha_nacimiento.date'     => 'La fecha de nacimiento debe ser un formato de fecha',
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json($validator->errors(), 400);
            }        
        }

        $persona = Persona::create([
            'nombre'            => $request->nombre,
            'apellido'          => $request->apellido,
            'fecha_nacimiento'  => $request->fecha_nacimiento,
        ]);

        if (!$persona) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Error al crear la persona'], 500);
            }
        }

        return response()->json($persona, 201);
    }

    public function show($id)
    {
        $persona = Persona::find($id);
        if (is_null($persona)) {
            return response()->json(['message' => 'Persona no encontrada'], 404);
        }
        return response()->json($persona);
    }

    public function update(Request $request, $id)
    {
        $persona = Persona::find($id);
        if (is_null($persona)) {
            return response()->json(['message' => 'Persona no encontrada'], 404);
        }

        $persona->update($request->all());
        return response()->json($persona);
    }

    public function destroy($id)
    {
        $persona = Persona::find($id);
        if (is_null($persona)) {
            return response()->json(['message' => 'Persona no encontrada'], 404);
        }

        $persona->delete();
        return response()->json(null, 204);
    }

    public function buscarPersona($contacto)
    {
        $persona = Persona::whereHas('contactos', function ($query) use ($contacto) {
            $query->where('descripcion', 'LIKE', "{$contacto}");
        })
        ->with('contactos', 'sexo', 'documentos')
        ->first();

        if(!$persona)
        {
            return response()->json([
                "mensaje" => "No se encontró el registro",
                "success" => false,
                "status" => 404
            ], 404);
        }

        return response()->json([
            "mensaje" => "Registro encontrado",
            "objeto" => $persona,
            "success" => true,
            "status" => 200
        ], 200);
    }

}
