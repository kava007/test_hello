

<div class="form-group">

  {!! Form::label('folio','Folio') !!}
  {!! Form::number('folio', null, ['class' => 'form-control']) !!}

</div>	

<div class="form-group">

  {!! Form::label('cliente','Cliente') !!}
  {!! Form::select('cliente_id', $clientes, null, ['class' => 'form-control']) !!}

</div>	

<div class="form-group">

  {!! Form::label('auto','Auto') !!}
  {!! Form::select('auto_id', $autos, null, ['class' => 'form-control']) !!}

</div>	


<div class="form-group">

  {!! Form::label('precio','Precio') !!}
  {!! Form::number('precio', null, ['class' => 'form-control']) !!}

</div>	



<div class="form-group">

  {!! Form::label('fecha_creacion','Fecha de creación') !!}
  {!! Form::date('fecha_creacion', \Carbon\Carbon::now(), ['class' => 'form-control', 'readonly' => 'readonly']) !!}

</div>	





<div class="form-group">

 
  {!! Form::submit('ENVIAR', ['class' => 'btn btn-primary']) !!}

</div>	