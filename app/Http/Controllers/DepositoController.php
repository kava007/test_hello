<?php

namespace App\Http\Controllers;

use App\Deposito;
use App\Cotizacion;
use App\DepositoCotizacion;
use Illuminate\Http\Request;
use App\Http\Requests\DepositoRequest;
use DB;
use Illuminate\Support\Facades;
Use Redirect;

class DepositoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$depositos = Deposito::orderBy('id','DESC')->get();
        //dd($depositos);

        $depositos = DB::select(DB::raw("SELECT depositos.id, 
                                   depositos.descripcion, 
                                   depositos.total,
                                   depositos.fecha_creacion,
                                   depositos.total -
                                   IF((SELECT SUM(monto_deposito_asignado)
                                       FROM depositos_cotizaciones
                                       WHERE depositos_cotizaciones.deposito_id =  depositos.id) IS NULL,0,(SELECT SUM(monto_deposito_asignado)
                                       FROM depositos_cotizaciones
                                       WHERE depositos_cotizaciones.deposito_id =  depositos.id)) AS saldo_deposito
                                    FROM depositos ORDER BY depositos.id DESC"));
        //dd($depositos);
        return view('depositos.index', ["depositos" => $depositos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('depositos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepositoRequest $request)
    {
        $deposito = new Deposito;
        $deposito->descripcion     = $request->descripcion;
        $deposito->total           = $request->total;
        $deposito->fecha_creacion  = $request->fecha_creacion;
        $deposito->save();
        
        return redirect()->route('depositos.index')
                         ->with('info','El depósito ha sido guardado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Deposito  $deposito
     * @return \Illuminate\Http\Response
     */
    public function show(Deposito $deposito)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Deposito  $deposito
     * @return \Illuminate\Http\Response
     */
    public function edit(Deposito $deposito)
    {

        return view('depositos.edit', compact('deposito'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Deposito  $deposito
     * @return \Illuminate\Http\Response
     */
    public function update(DepositoRequest $request, Deposito $deposito)
    {
       
        $deposito->descripcion     = $request->descripcion;
        $deposito->total           = $request->total;
        $deposito->fecha_creacion  = $request->fecha_creacion;
        $deposito->save();


        return redirect()->route('depositos.index')
                         ->with('info','El depósito con ID '.$deposito->id.' ha sido actualizado.');
    }

    
    public function destroy($id)
    {
        $deposito = Deposito::find($id);
        $deposito->delete();
        return back()->with('info','El depósito con ID '.$id.' fue eliminado.');
    }



    public function vincular($id_deposito, $saldo_deposito){
        //Vincular este depósito a una cotización
        
        /*
        $cotizaciones = DB::table('cotizaciones')
            ->join('clientes', 'cotizaciones.cliente_id', '=', 'clientes.id')
            ->join('autos', 'cotizaciones.auto_id', '=', 'autos.id')
            ->select('cotizaciones.*', 'clientes.nombre', 'autos.marca')
            ->orderBy('id','DESC')
            ->get();*/
            

        //dd($cotizaciones);

         $sql = "SELECT t1.id, 
                        t1.folio, 
                        t2.nombre,
                        t1.precio,
                        IF((SELECT SUM(monto_deposito_asignado) FROM depositos_cotizaciones WHERE cotizacion_id = t1.id) IS NULL, t1.precio, (t1.precio - (SELECT SUM(monto_deposito_asignado) FROM depositos_cotizaciones WHERE cotizacion_id = t1.id))) AS monto_x_liquidar
                        FROM cotizaciones AS t1
                        INNER JOIN clientes AS t2
                        ON t1.cliente_id = t2.id
                        WHERE (IF((SELECT SUM(monto_deposito_asignado) FROM depositos_cotizaciones WHERE cotizacion_id = t1.id) IS NULL, t1.precio, (t1.precio - (SELECT SUM(monto_deposito_asignado) FROM depositos_cotizaciones WHERE cotizacion_id = t1.id)))
                            ) > 0 ";
        $cotizaciones = DB::select( DB::raw($sql));        
        return view('depositos.vincular', compact('id_deposito','saldo_deposito','cotizaciones'));
    }

    public function guardarDepositoCotizacion(Request $request){

        $option_selected    = $request->input('cotizacion_id');
        $separar            = explode("|", $option_selected);
        $cotizacion_id      = trim($separar[0]);
        $monto_x_liquidar   = trim($separar[1]);

        $cantidad_depositar = $request->input('monto_deposito_asignado');  
        $saldo_deposito     = $request->input('saldo_deposito'); 

        $rules = [
            'monto_deposito_asignado' => 'required|numeric',
            'cotizacion_id'           => 'required',
        ];
 
        $messages = [
            'monto_deposito_asignado.required' => 'Agrega la cantidad a depositar.',
            'cotizacion_id.required'           => 'Elige la cotización a la que se asignará el depósito.'
        ];

        $v = $this->validate($request, $rules, $messages);
 
        if($cantidad_depositar > $saldo_deposito){
            //La cantidad a depositar no puede ser mayor que el saldo 
            return Redirect::back()->withInput()->withErrors(['No puedes depositar esa cantidad, no hay suficiente saldo en el depósito.']);    
        } 

        if($cantidad_depositar > $monto_x_liquidar){
            //La cantidad a depositar no puede ser mayor que el saldo 
            return Redirect::back()->withInput()->withErrors(['La cantidad que intentas depositar excede el monto por liquidar.']);    
        } 



        $deposito_cotizacion = DepositoCotizacion::create(
                ['deposito_id'             => $request->input('deposito_id'),
                 'cotizacion_id'           => $cotizacion_id,
                 'monto_deposito_asignado' => $cantidad_depositar,
                ]
        );

        return redirect('depositos');
    }

    public function traerDepositos($id){

        $data = []; 
        $sql = "SELECT deposito_id,
                       monto_deposito_asignado,
                       created_at
                       FROM depositos_cotizaciones 
                       WHERE cotizacion_id = ".$id." ORDER BY id DESC";
        $data['depositos'] = DB::select(DB::raw($sql));
        return $data['depositos'];
    }




}
