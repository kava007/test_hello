@extends('layouts.app')


@section('content')
<div class="container">
 <div class="row justify-content-center">
  <div class="col-sm-12">
  	<div class="card">
  		<div class="card-header">	

  		<h2>
  			Editar depósito	
  			<a href="{{ route('depositos.index') }}" class="btn btn-info pull-right">Listado</a>

  		</h2>
  		</div>

    @include('partials.error')

  	{!! Form::model($deposito, ['route' => ['depositos.update', $deposito->id], 'method' => 'PUT']) !!}


        @include('depositos.fragment.form')

    {!! Form::close() !!}
     </div>	
		
  </div> 
 </div>
</div>  

@endsection