<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empleados = Empleado::all();
        $arr=array();
        foreach($empleados as $c){
            $sucursal=Sucursal::find($c->sucursal_id);
            $cArr=$c->toArray();
            $cArr['nombre_s']=$sucursal->nombre;
            array_push($arr,$cArr);
        }

        Log::info($arr);
        return response()->json(['message' => 'success', 'empleados'=>$arr]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('nombre_s');
        $data['sucursal_id'] = Sucursal::where('nombre', $request->nombre_s)->first()->id;
        $data['user_id']=auth()->user()->id;
        Empleado::insert($data);
        return response()->json(['message'=>'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleados
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleados
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empleado $empleado)
    {
        $data = $request->except('nombre_s');
        $data['sucursal_id'] = Sucursal::where('nombre', $request->nombre_s)->first()->id;
        $data['user_id']=auth()->user()->id;
        empleado::where('id', $empleado->id)->update($data);
        return response()->json(["message"=>"success"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $empleados
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empleado $document)
    {
        Empleado::where('id', $document->id)->delete();
        return response()->json(["message"=>"success"]);
    }
}
