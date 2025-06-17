<?php

namespace App\Http\Controllers;

use App\Models\TipoContacto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipoContactoController extends Controller
{
    private $model = TipoContacto::class;
    private $table = "tipo_contacto";
    //
    public function index(Request $request)
    {
        return view('tablasMaestras.tipo_contacto.index');
    }

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

    public function create() 
    {
        return view("tablasMaestras.{$this->table}.crear");
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'descripcion' => "required|unique:{$this->table},descripcion|string|max:50",
        ],
        [
            'descripcion.required' => 'El campo es obligatorio',
            'descripcion.unique'   => 'El campo ya existe',
            'descripcion.string'   => 'El campo debe ser un texto',
            'descripcion.max'      => 'El campo es demaciado largo'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 400);
        }

        $objeto = $this->model::create([
            "descripcion" => $request->descripcion,
        ]);

        if (!$objeto) {
            return response()->json(['message' => 'Error al crear el registro'], 500);
        }

        return redirect()->route("{$this->table}.index")->with('success', true);
    }

    public function edit($id) 
    {
        $objeto = $this->model::find($id);

        if (!$objeto) {
            return redirect()->route("{$this->table}.index")->with('error', 'registro no encontrado');
        }

        $data = [
            "objeto" => $objeto,
            "table"  => $this->table,
        ];

        return view("tablasMaestras.{$this->table}.modificar", $data);
    }

    public function update(Request $request, $id)
    {
        // 1. Validación
        $validator = Validator::make($request->all(), [
            'descripcion' => "required|unique:{$this->table},descripcion",
        ],
        [
            'descripcion.required' => 'El campo es obligatorio',
            'descripcion.unique'   => 'El campo debe ser único',
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

        // 3. Actualizar el campo
        $objeto->descripcion = $request->descripcion;
        $objeto->save(); // timestamps se actualizan solos

        // 4. Redirigir con mensaje de éxito
        return redirect()->route("{$this->table}.index")->with('success', 'registro actualizado correctamente');
    }

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
