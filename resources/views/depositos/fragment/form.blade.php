<div class="form-group">

  {!! Form::label('descripcion','Descripción del depósito') !!}
  {!! Form::textarea('descripcion', null, ['class' => 'form-control', 'rows' => 2, 'cols' => 40]) !!}

</div>	

<div class="form-group">

  {!! Form::label('total','Total del depósito') !!}
  {!! Form::number('total', null, ['class' => 'form-control']) !!}

</div>	


<div class="form-group">

  {!! Form::label('fecha_creacion','Fecha de creación') !!}
  {!! Form::date('fecha_creacion', \Carbon\Carbon::now(), ['class' => 'form-control', 'readonly' => 'readonly']) !!}

</div>	





<div class="form-group">

 
  {!! Form::submit('ENVIAR', ['class' => 'btn btn-primary']) !!}

</div>	