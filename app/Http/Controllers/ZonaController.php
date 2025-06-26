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
        $this->validateRequest($request);

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

    private function validateRequest(Request $request): void
    {
        $validator = Validator::make($request->all(), [
            'descripcion'         => "required|unique:{$this->table},descripcion",
            'dimension'           => 'required|string',
            'rela_deporte'        => 'required|integer|exists:deporte,id',
            'rela_tipo_deporte'   => 'required|integer|exists:tipo_deporte,id',
            'rela_superficie'     => 'required|integer|exists:superficie,id',
            'rela_estado_zona'    => 'required|integer|exists:estado_zona,id',
            'rela_sucursal'       => 'required|integer|exists:sucursal,id',
        ], [
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
        ]);

        if ($validator->fails()) {
            // Tiramos un HTTP 400 con los errores como array
            response()->json($validator->errors()->all(), 400)->throwResponse();
        }
    }
}
