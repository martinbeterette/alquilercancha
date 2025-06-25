<?php

namespace App\Http\Controllers;

use App\Models\Zona;
use App\Models\Deporte;
use App\Models\TipoDeporte;
use App\Models\Superficie;
use App\Models\EstadoZona;
use App\Models\Sucursal;

use Illuminate\Http\Request;


// REVISAR TODOS LOS METODOS!!!
class ZonaController extends Controller
{
    private $table = "zona";
    private $model = Zona::class;
    private $campos = [];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() 
    {
        $deportes       = Deporte::all();
        $tipoDeporte    = TipoDeporte::all();
        $superficie     = Superficie::all();
        $estadoZona     = EstadoZona::all();
        $sucursal       = Sucursal::all();
        $idSucursal     = request()->query('sucursal') ?? null;

        if(!$idSucursal) {
            return redirect()->route('sucursal.index');
        }

        $data = [
            "deporte"       => $deportes,
            "tipo_deporte"  => $tipoDeporte,
            "superficie"    => $superficie,
            "estado_zona"   => $estadoZona,
            "sucursal"      => $sucursal,
            "id_sucursal"   => $idSucursal,
            "table"         => $this->table,
        ];
        //hay que cambiar esto
        return view("{$this->table}.crear", $data);
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
        $objeto->load([
            'tipoDeporte.deporte',
            'sucursales',
            'superficie',
            'estadoZona',
            'tipoZona',
        ]);
        $deportes       = Deporte::all();
        $tipoDeporte    = TipoDeporte::all();
        $superficie     = Superficie::all();
        $estadoZona     = EstadoZona::all();
        $sucursal       = Sucursal::all();
        $idSucursal     = request()->query('sucursal') ?? null;

        if(!$idSucursal) {
            return redirect()->route('sucursal.index');
        }


        if (!$objeto) {
            return redirect()->route("{$this->table}.index")->with('error', 'registro no encontrado');
        }

        // Simular campo 'rela_deporte' para que el helper de select lo agarre
        $objeto->rela_deporte = optional($objeto->tipoDeporte->deporte)->id;

        $data = [
            "objeto"        => $objeto,
            "deporte"       => $deportes,
            "tipo_deporte"  => $tipoDeporte,
            "superficie"    => $superficie,
            "estado_zona"   => $estadoZona,
            "sucursal"      => $sucursal,
            "id_sucursal"   => $idSucursal,
            "table"         => $this->table,
        ];


        return view("{$this->table}.modificar", $data);
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
