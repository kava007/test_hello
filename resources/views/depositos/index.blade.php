@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">

                  <h2>
                    Listado de Depósitos
                   @if(Auth::user()->admin == 1)
                       <a href="{{ route('depositos.create') }}" class="btn btn-primary pull-right">Nuevo Depósito</a> 
                   @endif                    

                  </h2>

                </div>

                @include('partials.info')

                <div class="card-body">


                	<table class="table table-hover table-striped">

                		<thead>
                          <tr>  
                			<th width="10px">ID</th>
                			<th>Descripción</th>
                			<th>Total Depósito</th>
                      <th>Fecha Depósito</th>
                      <th>Saldo x asignar</th>
                			<th colspan="3">&nbsp;</th>
                           </tr> 
                		</thead>

                		<tbody>
                         
                          @foreach($depositos as $deposito) 
                           <tr> 
                              <td>{{ $deposito->id }}</td>
                              <td>{{ $deposito->descripcion }}</td>
                              <td>$ {{ number_format($deposito->total,2) }}</td>
                              <td>{{ $deposito->fecha_creacion }}</td>
                              <td>$ {{ number_format($deposito->saldo_deposito,2) }}</td>
                              <td width="10px">
                                 @if(Auth::user()->admin == 1)
                                 <a href="{{ route('depositos.edit', $deposito->id) }}" class="btn btn-sm btn-primary">Editar</a>
                                 @endif

                               </td>
                              <td width="10px">
                               
                                @if(Auth::user()->admin == 1)
                               <form action="{{ route('depositos.destroy', $deposito->id) }}" method="POST">    
 
                                   <input type="hidden" name="_method" value="DELETE"/>
                        
                                   {{ csrf_field() }}
                                   <button class="btn btn-sm btn-danger">Eliminar</button>

                               </form>  
                               @endif 



                              </td>

                         
                              <td width="10px">

                               @if(Auth::user()->admin == 0)    
                                  @if($deposito->saldo_deposito > 0)
                                    <a href="{{ url('vincular', ['id' => $deposito->id, 'saldo' => $deposito->saldo_deposito]) }}" class="btn btn-sm btn-success">
                                    Vincular a Cotización
                                    </a>
                                  @endif  
                               @endif    



                              </td>


                            

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
