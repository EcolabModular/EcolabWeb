@extends('layouts.tema')

@section('titulo_contenido')
    @if(isset($laboratory))
        Editar Laboratorio
    @else
        Registrar Laboratorio
    @endif
@endsection
@section('subtitulo_contenido')
    @if(isset($laboratory))
        Editar Laboratorio: {{$laboratory->name}}
    @else
        Registrar Laboratorio en el Sistema
    @endif
@endsection
@section('ruta_ref') <a href="{{ url('/admin/laboratories') }}">Laboratorios</a> @endsection

@section('contenido')

<div class="row">
  <div class="col-md-12">
    <div class="tile">

      <h3 class="tile-title">Complete los siguientes campos</h3>
      <div class="tile-body">

        @if(isset($laboratory))
          {!! Form::model($laboratory, ['route' => ['items.update', $laboratory->id], 'method' => 'PUT']) !!}
        @else
          {!! Form::open(['action' => 'Laboratory\LaboratoryController@store', 'method' => 'POST']) !!}
        @endif

        @csrf

          <div class="form-group">
            <label for="name" class="control-label">Nombre</label>
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Escriba el nombre del laboratorio']); !!}
          </div>

          <div class="form-group">
            <label for="description" class="control-label">Descripción</label>
            {!! Form::textarea('description' , null , ['class' => 'form-control']) !!}
          </div>

          <div class="form-group">
            <label for="institution_id" class="control-label">Instituto</label>
            {!! Form::select('institution_id',  $institutionsArray, null, ['class' => 'form-control', 'placeholder' => 'Selecciona un instituto...']) !!}
          </div>

          <div class="tile-footer">
            <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Registrar</button>
          </div>

        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
@endsection
