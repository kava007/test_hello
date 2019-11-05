@extends('layouts.app')


@section('content')
<div class="container">
 <div class="row justify-content-center">
  <div class="col-sm-12">
  	<div class="card">
  		<div class="card-header">	

  		<h2>
  			Vincular depósito [ID: {{ $id_deposito }}]	
  	    </h2>
  	    <h4>
  	    	Saldo depósito <span class="alert alert-success">$ {{ number_format($saldo_deposito, 2) }}</span>
  	    </h4>	
  		</div>

        @include('partials.error')

        {!! Form::open(['url' => 'guardarDepositoCotizacion', 'method' => 'post']) !!}

            <div class="form-group">

		     {!! Form::label('monto_deposito_asignado','Cantidad a depositar') !!}
		     {!! Form::number('monto_deposito_asignado', null, ['class' => 'form-control']) !!}
            </div>

             <div class="form-group">
             {!! Form::hidden('saldo_deposito', $saldo_deposito) !!}
		     {!! Form::hidden('deposito_id', $id_deposito) !!}
            </div>

            <div class="form-group">

             {!! Form::label('cotizacion_id','Cotización') !!}
  			 <select name="cotizacion_id">
  			 	   <option value=""></option>
  			 	@foreach($cotizaciones as $cotizacion)
             
                   <option value="{{ $cotizacion->id }} | {{ $cotizacion->monto_x_liquidar }}">
        			 	      Folio:   {{ $cotizacion->folio }}  |
        			 	      Cliente: {{ $cotizacion->nombre }} |  
        			 	      Monto por liquidar:  {{ number_format($cotizacion->monto_x_liquidar,2) }}
  			 	         </option>
            
  			 	@endforeach	
  			 </select>	

            </div>	

            <div class="form-group">
              {!! Form::submit('ENVIAR', ['class' => 'btn btn-primary']) !!}
            </div>	

	    {!! Form::close() !!}



  
     </div>	
		
  </div> 
 </div>
</div>  

@endsection