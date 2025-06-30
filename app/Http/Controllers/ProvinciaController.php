<?php

namespace App\Http\Controllers;

use App\Models\Provincia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProvinciaController extends Controller
{
    private $model  = Provincia::class;
    private $table  = 'provincia';
    private $route  = "tablasMaestras.provincia";
    private $campos = ['descripcion'];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("{$this->route}.index");
    }

    /**
     * Display a listing of the resource in JSON format.
     */
    public function indexApi(Request $request)
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
        
        return view("{$this->route}.crear");
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

        return redirect()->route("{$this->table}.index")->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(Provincia $provincia)
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
            return redirect()->route("{$this->table}.index")->with('error', 'registro no encontrado');
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

    private function validateRequest(Request $request, ?int $id = null)
    {
        $rules = [
            'descripcion' => [
                'required',
                'max:20',
                Rule::unique($this->table, 'descripcion')->ignore($id),
            ],
        ];

        $messages = [
            'descripcion.required'         => 'La descripción es obligatoria.',
            'descripcion.unique'           => 'Ya existe una zona con esa descripción.',
            'descripcion.max'              => 'La descripcion es demaciado larga.',
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
