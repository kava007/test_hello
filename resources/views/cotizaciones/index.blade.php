@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">

                  <h2>
                    Listado de Cotizaciones

                    @if(Auth::user()->admin == 0)
                    <a href="{{ route('cotizaciones.create') }}" class="btn btn-primary pull-right">Nueva Cotización</a>  
                    @endif


                  </h2>

                </div>

                @include('partials.info')
                @include('partials.modal')

                <div class="card-body">


                	<table class="table table-hover table-striped">

                		<thead>
                      <tr>  
                  			<th width="10px">ID</th>
                  			<th>Folio</th>
                  			<th>Cliente</th>
                        <th>Auto</th>
                        <th>Precio</th>
                        <th>Fecha<br>Cotización</th>
                        <th># Depósitos<br>recibidos</th>
                        <th>Monto<br>por liquidar</th>
                      </tr> 
                		</thead>

                		<tbody>

                      @foreach($cotizaciones as $cotizacion)
                        <tr>  
                          <td>{{ $cotizacion->id }}</td>
                          <td>{{ $cotizacion->folio }}</td>
                          <td>{{ $cotizacion->cliente }}</td>
                          <td>{{ $cotizacion->auto }}</td>
                          <td>$ {{ number_format($cotizacion->precio, 2) }}</td>
                          <td>{{ $cotizacion->fecha_creacion }}</td>
                          <td align="center">
                          
                            <button type="button" class="btn btn-primary btn-sm" onclick="traerDepositos(<?php echo $cotizacion->id;?>, <?php echo $cotizacion->folio;?>)">
                                {{ $cotizacion->num_depositos_recibidos }}
                            </button>
                            
                          </td>
                          <td>$ {{ number_format($cotizacion->monto_x_liquidar, 2) }}</td>
                         
                          
                        </tr> 
                      @endforeach
                     
                         
                    </tbody>
                		
                	</table>
                   

                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script src="{{ asset('js/script.js?id=4') }}" defer></script>

@endsection
