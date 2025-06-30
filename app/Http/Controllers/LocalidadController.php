<?php

namespace App\Http\Controllers;

use App\Models\Localidad;
use App\Models\Provincia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LocalidadController extends Controller
{
    private $model = Localidad::class;
    private $table = 'localidad';
    private $route = "tablasMaestras.{$this->table}";
    private $campos = ['descripcion', 'rela_provincia'];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("{$this->route}.index");
    }

    public function indexApi()
    {
        //iniciamos el query y filtro
        $query  = $this->model::query();
        // $query = TipoContacto::where('activo', true);
        $filtro = $request->filtro ?? null;
        
        //si el filtro no es vacio, lo aplicamos
        if(!empty($filtro)){
            $campos = ["id", "descripcion"];
            $query->where(function($q) use ($filtro, $campos) {
                foreach ($campos as $campo) {
                    $q->orWhere($campo, 'LIKE', "%$filtro%");
                }

                 // 🔍 Buscamos por la descripción del deporte relacionado
                $q->orWhereHas('provincia', function($sub) use ($filtro) {
                    $sub->where('descripcion', 'LIKE', "%$filtro%");
                });
            });
        }

        //tomamos el Request y calculos del paginado
        $paginaActual       = $request->page ?? 1;
        $registrosPorPagina = $request->registros_por_pagina ?? 10;
        $offset             = ($paginaActual - 1) * $registrosPorPagina;
        $totalRegistros     = $query->count();
        $totalPaginas       = ceil($totalRegistros / $registrosPorPagina);
        

        
        //ejecutamos el query
        $registros = $query
            ->with(['provincia'])
            ->offset($offset)
            ->limit($registrosPorPagina)
            ->orderBy('id', 'asc')
            ->get();

        // Preparamos la respuesta
        $data = (object)[
            "data"              => $registros,
            "total_registros"   => $totalRegistros,
            "pagina"            => $paginaActual,
            "total_paginas"     => $totalPaginas,
        ];

        //retornamos la respuesta
        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() 
    {
        $data = [
            "provincia" => Provincia::all(),
        ];
        return view("{$this->route}.crear", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validación
        $error = $this->validateRequest($request);
        if ($error) return $error;

        // 2. Crear y asignar campos
        $objeto = new $this->model;

        foreach ($this->campos as $campo) {
            if ($request->has($campo)) {
                $objeto->$campo = $request->$campo;
            }
        }

        // 3. Guardar
        $objeto->save();

        return redirect()->route("{$this->route}.index")->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(Localidad $localidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) 
    {
        $objeto = $this->model::find($id);

        if (!$objeto) {
            return redirect()->route("{$this->route}.index")->with('error', 'registro no encontrado');
        }

        $data = [
            "objeto"        => $objeto,
            "table"         => $this->table,
        ];


        return view("{$this->route}.modificar", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $error = $this->validateRequest($request, $id);
        if ($error) return $error;
    
        $objeto = $this->model::find($id);

        if (!$objeto) {
            $data = [
                "message" => "No se pudo encontrar el registro",
                "success" => false,
            ];
            return redirect()->route("errors.review")->with($data);
        }

        foreach ($this->campos as $campo) {
            if ($request->has($campo)) {
                $objeto->$campo = $request->$campo;
            }
        }

        // 3. Actualizar el campo
        $objeto->save(); // timestamps se actualizan solos

        // 4. Redirigir con mensaje de éxito
        return redirect()->route("{$this->route}.index")->with('success', 'registro actualizado correctamente');
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
            return redirect()->route("{$this->route}.index")->with($data);
        }

        // 2. "Eliminar" el registro (soft delete )
        $objeto->delete();

        // 3. Redirigir con mensaje de éxito
        return redirect()->route("{$this->route}.index")->with('success', 'Registro eliminado correctamente');
    }

    private function validateRequest(Request $request, ?int $id = null)
    {
        $rules = [
            'descripcion'         => [
                'required',
                Rule::unique($this->table, 'descripcion')->ignore($id),
            ],
            'dimension'           => 'required|string',
            'rela_deporte'        => 'required|integer|exists:deporte,id',
            'rela_tipo_deporte'   => 'required|integer|exists:tipo_deporte,id',
            'rela_superficie'     => 'required|integer|exists:superficie,id',
            'rela_estado_zona'    => 'required|integer|exists:estado_zona,id',
            'rela_sucursal'       => 'required|integer|exists:sucursal,id',
        ];

        $messages = [
            'descripcion.required'         => 'La descripción es obligatoria.',
            'descripcion.unique'           => 'Ya existe una zona con esa descripción.',

            'dimension.required'           => 'La dimensión es obligatoria.',
            'dimension.string'             => 'La dimensión debe ser texto.',

            'rela_deporte.required'        => 'Debés seleccionar un deporte.',
            'rela_deporte.integer'         => 'El deporte no es válido.',
            'rela_deporte.exists'          => 'El deporte no existe.',

            'rela_tipo_deporte.required'   => 'Debés seleccionar un tipo de deporte.',
            'rela_tipo_deporte.integer'    => 'El tipo de deporte no es válido.',
            'rela_tipo_deporte.exists'     => 'El tipo de deporte no existe.',

            'rela_superficie.required'     => 'Debés seleccionar una superficie.',
            'rela_superficie.integer'      => 'La superficie no es válida.',
            'rela_superficie.exists'       => 'La superficie no existe.',

            'rela_estado_zona.required'    => 'Debés seleccionar un estado.',
            'rela_estado_zona.integer'     => 'El estado no es válido.',
            'rela_estado_zona.exists'      => 'El estado no existe.',

            'rela_sucursal.required'       => 'Debés seleccionar una sucursal.',
            'rela_sucursal.integer'        => 'La sucursal no es válida.',
            'rela_sucursal.exists'         => 'La sucursal no existe.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return view("errors.review", [
                "message" => "Error durante la validacion de los datos",
                "errors" => $validator->errors()->all(),
                "success" => false,
            ]);
        }

        return null;
    }
}
