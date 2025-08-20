<?php

namespace App\Http\Controllers;

use App\Models\Zona;
use App\Models\Deporte;
use App\Models\TipoDeporte;
use App\Models\Superficie;
use App\Models\EstadoZona;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;



// REVISAR TODOS LOS METODOS!!!
class ZonaController extends Controller
{
    private $table = "zona";
    private $model = Zona::class;
    private $campos = [
        'descripcion',
        'dimension',
        'rela_tipo_deporte',
        'rela_superficie',
        'rela_estado_zona',
        'rela_sucursal',
    ];

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

        //le asignamos el tipo de zona = cancha
        $objeto->rela_tipo_zona = 1; // 1 = cancha

        // 3. Guardar
        $objeto->save();

        return redirect()->route("sucursal.show", ['sucursal' => $objeto->rela_sucursal])->with('success', true);
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
        

        // 2. Buscar el registro
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

        //le asignamos el tipo de zona = cancha
        $objeto->rela_tipo_zona = 1; // 1 = cancha

        // 3. Actualizar el campo
        $objeto->save(); // timestamps se actualizan solos

        // 4. Redirigir con mensaje de éxito
        return redirect()->route("sucursal.show", ["sucursal" => $objeto->rela_sucursal])->with('success', 'registro actualizado correctamente');
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
        $sucursal = $objeto->rela_sucursal;

        // 2. "Eliminar" el registro (soft delete )
        $objeto->delete();

        // 3. Redirigir con mensaje de éxito
        return redirect()->route("sucursal.show", ['sucursal' => $sucursal])->with('success', 'Registro eliminado correctamente');
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

    /**
     *Obtener canchas por sucursal
     *@param Sucursal $sucursal la sucursal con la que filtramos
     *@return \Illuminate\Http\JsonResponse array de canchas por sucursal
     */  
    public function canchasPorSucursal(Sucursal $sucursal)
    {
        $canchas = $sucursal
            ->zonas()
            ->where('rela_tipo_zona',1)
            ->with('tipoZona', 'superficie','tipoDeporte')
            ->get();

        return response()->json([
            "message" => "Canchas de la sucursal $sucursal->id",
            "canchas" => $canchas,
            "success" => true,
            "status" => 200,
        ], 200);
    }
}
