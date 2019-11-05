@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
         <div class="card">
              <div class="card-header">	

			  		<h2>
			  		    Nueva cotización	
			  			<a href="{{ route('cotizaciones.index') }}" class="btn btn-info pull-right">Listado</a>

			  		</h2>
		  	   </div>

		  	    @include('partials.error')

    
			       {!! Form::open(['route' => 'cotizaciones.store']) !!}

			          @include('cotizaciones.fragment.form')

			       {!! Form::close() !!}
	    </div>		       

		
  </div> 
 </div> 
</div>   


@endsection