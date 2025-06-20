<?php

namespace App\Http\Controllers;

use App\Models\Deporte;
use App\Models\TipoDeporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipoDeporteController extends Controller
{
    private $table = 'tipo_deporte';
    private $model = TipoDeporte::class;
    private $campos = ['descripcion', 'rela_deporte'];
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view("tablasMaestras.{$this->table}.index");
    }

    public function indexApi(Request $request)
    {
        $query  = $this->model::query(); // asumimos que ya está set $this->model = TipoDeporte::class
        $filtro = $request->filtro ?? null;

        if (!empty($filtro)) {
            $campos = ["id", "descripcion"];

            $query->where(function($q) use ($filtro, $campos) {
                foreach ($campos as $campo) {
                    $q->orWhere($campo, 'LIKE', "%$filtro%");
                }

                // 🔍 Buscamos por la descripción del deporte relacionado
                $q->orWhereHas('deporte', function($sub) use ($filtro) {
                    $sub->where('descripcion', 'LIKE', "%$filtro%");
                });
            });
        }

        // Paginado
        $paginaActual       = $request->page ?? 1;
        $registrosPorPagina = $request->registros_por_pagina ?? 10;
        $offset             = ($paginaActual - 1) * $registrosPorPagina;
        $totalRegistros     = $query->count();
        $totalPaginas       = ceil($totalRegistros / $registrosPorPagina);

        // ⬅️ Cargamos también el objeto 'deporte'
        $registros = $query
            ->with(['deporte']) // eager load de la relación
            ->offset($offset)
            ->limit($registrosPorPagina)
            ->orderBy('id', 'asc')
            ->get();

        $data = (object)[
            "data"             => $registros,
            "total_registros" => $totalRegistros,
            "pagina"           => $paginaActual,
            "total_paginas"    => $totalPaginas,
        ];

        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() 
    {
        $deportes = Deporte::all();

        $data = [
            "deportes" => $deportes,
            "table" => $this->table,
        ];
        return view("tablasMaestras.{$this->table}.crear", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validación
        $validator = Validator::make($request->all(), [
            'descripcion'    => "required|unique:{$this->table},descripcion",
            'rela_deporte'   => "required|integer|exists:deporte,id",
        ],
        [
            'descripcion.required'   => 'La descripción es obligatoria.',
            'descripcion.unique'     => 'Ya existe un registro con esa descripción.',

            'rela_deporte.required'  => 'Debés seleccionar un deporte.',
            'rela_deporte.integer'   => 'El valor seleccionado no es válido.',
            'rela_deporte.exists'    => 'El deporte seleccionado no existe en la base de datos.',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 400);
        }

        $objeto = new $this->model;

        foreach ($this->campos as $campo) {
            if ($request->has($campo)) {
                $objeto->$campo = $request->$campo;
            }
        }

        // 3. Actualizar el campo
        $objeto->save(); // timestamps se actualizan solos

        return redirect()->route("{$this->table}.index")->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $resultado = TipoDeporte::find($id);

        if (!$resultado) {
            return response()->json(['message' => 'Tipo de contacto no encontrado'], 404);
        }

        return response()->json($resultado,201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) 
    {
        $objeto = $this->model::find($id);
        $objeto->load('deporte');
        $deportes = Deporte::all();

        if (!$objeto) {
            return redirect()->route("{$this->table}.index")->with('error', 'registro no encontrado');
        }

        $data = [
            "objeto"    => $objeto,
            "deportes"  => $deportes,
            "table"     => $this->table,
        ];

        return view("tablasMaestras.{$this->table}.modificar", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // 1. Validación
        $validator = Validator::make($request->all(), [
            'descripcion'    => "required|unique:{$this->table},descripcion,{$id}",
            'rela_deporte'   => "required|integer|exists:deporte,id",
        ],
        [
            'descripcion.required'   => 'La descripción es obligatoria.',
            'descripcion.unique'     => 'Ya existe un registro con esa descripción.',

            'rela_deporte.required'  => 'Debés seleccionar un deporte.',
            'rela_deporte.integer'   => 'El valor seleccionado no es válido.',
            'rela_deporte.exists'    => 'El deporte seleccionado no existe en la base de datos.',
        ]);

        if ($validator->fails()) {
            $data = [
                "message" => "Error en la validación de los datos",
                "errors"  => $validator->errors()->all(),
                "success" => false,
            ];
            return redirect()->route("{$this->table}.index")->with($data);
        }

        // 2. Buscar el registro
        $objeto = $this->model::find($id);

        if (!$objeto) {
            $data = [
                "message" => "Error en la validación de los datos",
                "success" => false,
            ];
            return redirect()->route("{$this->table}.index")->with($data);
        }

        foreach ($this->campos as $campo) {
            if ($request->has($campo)) {
                $objeto->$campo = $request->$campo;
            }
        }

        // 3. Actualizar el campo
        $objeto->save(); // timestamps se actualizan solos

        // 4. Redirigir con mensaje de éxito
        return redirect()->route("{$this->table}.index")->with('success', 'registro actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // 1. Buscar el registro
        $objeto = $this->model::find($id);

        if (!$objeto) {
            $data = [
                "message" => "registro no encontrado",
                "success" => false,
            ];
            return redirect()->route("{$this->table}.index")->with($data);
        }

        // 2. "Eliminar" el registro (soft delete )
        $objeto->delete();

        // 3. Redirigir con mensaje de éxito
        return redirect()->route("{$this->table}.index")->with('success', 'Registro eliminado correctamente');
    }
}
