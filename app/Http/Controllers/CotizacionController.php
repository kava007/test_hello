<?php

namespace App\Http\Controllers;

use App\Cotizacion;
use App\Cliente;
use App\Auto;
use Illuminate\Http\Request;
use DB;

use App\Http\Requests\CotizacionRequest;

class CotizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$cotizaciones = Cotizacion::orderBy('id','DESC')->get();

        /*
        $cotizaciones = DB::table('cotizaciones')
            ->join('clientes', 'cotizaciones.cliente_id', '=', 'clientes.id')
            ->join('autos', 'cotizaciones.auto_id', '=', 'autos.id')
            ->select('cotizaciones.*', 'clientes.nombre', 'autos.marca')
            ->orderBy('id','DESC')
            ->get();
        */

                   $sql = "SELECT t1.id, t1.folio, 
                           t2.nombre as cliente, 
                           t3.marca as auto,    
                           t1.precio, t1.fecha_creacion,
                           (SELECT count(id) FROM depositos_cotizaciones
                             WHERE cotizacion_id = t1.id
                           ) AS num_depositos_recibidos, 
                           IF((SELECT SUM(monto_deposito_asignado) FROM depositos_cotizaciones WHERE cotizacion_id = t1.id) IS NULL, t1.precio, (t1.precio - (SELECT SUM(monto_deposito_asignado) FROM depositos_cotizaciones WHERE cotizacion_id = t1.id))) AS monto_x_liquidar
                           FROM cotizaciones AS t1
                           INNER JOIN clientes AS t2
                           ON t1.cliente_id = t2.id    
                           INNER JOIN autos AS t3
                           ON t1.auto_id = t3.id        
                           ORDER BY t1.id DESC";
        $cotizaciones = DB::select( DB::raw($sql));    
        //dd($cotizaciones);
        return view('cotizaciones.index', compact('cotizaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

     $clientes = Cliente::select(DB::raw("CONCAT(nombre,' - ',email) AS nombre"),'id')
                                 ->pluck('nombre', 'id');

     $autos = Auto::select(DB::raw("CONCAT(marca,' ',modelo,' ',anio) AS auto"),'id')
                           ->pluck('auto', 'id');

     return view('cotizaciones.create', compact('clientes','autos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CotizacionRequest $request)
    {
        //
        $cotizacion = new Cotizacion;
        $cotizacion->folio          = $request->folio;
        $cotizacion->cliente_id     = $request->cliente_id;
        $cotizacion->auto_id        = $request->auto_id;
        $cotizacion->precio         = $request->precio;
        $cotizacion->fecha_creacion = $request->fecha_creacion;
        $cotizacion->save();
        
        return redirect()->route('cotizaciones.index')
                         ->with('info','La cotización ha sido guardada.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cotizacion  $cotizacion
     * @return \Illuminate\Http\Response
     */
    public function show(Cotizacion $cotizacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cotizacion  $cotizacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Cotizacion $cotizacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cotizacion  $cotizacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cotizacion $cotizacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cotizacion  $cotizacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cotizacion $cotizacion)
    {
        //
    }
}
