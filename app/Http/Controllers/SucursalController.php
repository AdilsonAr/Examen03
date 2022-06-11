<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Sucursals = Sucursal::all();

        return response()->json(['message' => 'success', 'sucursals'=>$Sucursals]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Sucursal::insert($request->all());
        return response()->json(['message'=>'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sucursal  $Sucursals
     * @return \Illuminate\Http\Response
     */
    public function show(Sucursal $Sucursal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sucursal  $Sucursals
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sucursal $Sucursal)
    {
        Sucursal::where('id', $Sucursal->id)->update($request->all());
        return response()->json(["message"=>"success"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sucursal  $Sucursals
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sucursal $Sucursal)
    {
        Sucursal::where('id', $Sucursal->id)->delete();
        return response()->json(["message"=>"success"]);
    }
}
