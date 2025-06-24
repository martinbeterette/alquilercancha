<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SucursalController extends Controller
{
    private $table = 'sucursal';
    private $model = Sucursal::class;
    private $campos = ['nombre', 'direccion', 'rela_complejo'];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sucursales = Sucursal::all(); // después vos filtrás si querés
        return view('sucursales.index', compact('sucursales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() 
    {
        return view("sucursales.crear");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validación
        $validator = Validator::make($request->all(), [
            'nombre'    => "required|unique:{$this->table},nombre",
            'direccion'    => "required|string|max:100",
        ],
        [
            'nombre.required'   => 'El nombre es obligatoria.',
            'nombre.unique'     => 'Ya existe un registro con este nombre.',
            'direccion.max'         => 'el campo ingresado es demaciado largo',
            'direccion.required'    => 'Este campo es requerido',
            'direccion.string'      => 'el campo debe ser una cadena de texto',
        ]);

        if ($validator->fails()) {
            $data = [
                "message" => "Error en la validacion de los datos",
                "errors" => $validator->errors()->all(),
            ];
            return view("errors.review", $data);
        }

        $objeto = new $this->model;
        $objeto->rela_complejo = 1;
        foreach ($this->campos as $campo) {
            if ($request->has($campo)) {
                $objeto->$campo = $request->$campo;
            }
        }

        // 3. Actualizar el campo
        $objeto->save(); // timestamps se actualizan solos

        return redirect()->route("$this->table.index")->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
         $sucursal = Sucursal::find($id);

         if (!$sucursal) {
            $data = [
                "message" => "Sucursal no encontrada",
                "status"  => "400",
            ];
            return response()->json($data);
         }

         $sucursal->load('zonas');
        // ya después le agregás las canchas asociadas en la vista
        return view('sucursales.show', compact('sucursal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) 
    {
        $objeto = $this->model::find($id);

        if (!$objeto) {
            return redirect()->route("$this->table.index")->with('error', 'registro no encontrado');
        }

        $data = [
            "objeto"    => $objeto,
            "table"     => $this->table,
        ];

        return view("sucursales.modificar", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // 1. Validación
        $validator = Validator::make($request->all(), [
            'nombre'    => "required|unique:{$this->table},nombre,{$id}",
            'direccion'    => "required|string|max:100",
        ],
        [
            'nombre.required'   => 'El nombre es obligatoria.',
            'nombre.unique'     => 'Ya existe un registro con este nombre.',
        ],
        [
            'direccion.required'    => 'Este campo es requerido',
            'direccion.string'      => 'el campo debe ser una cadena de texto',
            'direccion.max'         => 'el campo ingresado es demaciado largo',
        ]);

        if ($validator->fails()) {
            $data = [
                "message" => "Error en la validación de los datos",
                "errors"  => $validator->errors()->all(),
                "success" => false,
            ];
            // return response()->json($data);
            return view("errors.review", $data);
        }

        // 2. Buscar el registro
        $objeto = $this->model::find($id);

        if (!$objeto) {
            $data = [
                "message" => "Error al encontrar el registro",
                "success" => false,
            ];
            return redirect()->route("$this->table.index")->with($data);
        }

        foreach ($this->campos as $campo) {
            if ($request->has($campo)) {
                $objeto->$campo = $request->$campo;
            }
        }

        // 3. Actualizar el campo
        $objeto->save(); // timestamps se actualizan solos

        // 4. Redirigir con mensaje de éxito
        return redirect()->route("$this->table.index")->with('success', 'registro actualizado correctamente');
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
            return redirect()->route("$this->table.index")->with($data);
        }

        // 2. "Eliminar" el registro (soft delete )
        $objeto->delete();

        // 3. Redirigir con mensaje de éxito
        return redirect()->route("{$this->table}.index")->with('success', 'Registro eliminado correctamente');
    }
}
