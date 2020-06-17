@extends('layouts.tema')

@section('titulo_contenido')
    @if(isset($institution))
        Editar Instituto
    @else
        Registrar Instituto
    @endif
@endsection
@section('subtitulo_contenido')
    @if(isset($institution))
        Editar Insituto: {{$institution->name}}
    @else
        Registrar Instituto en el Sistema
    @endif
@endsection
@section('rutas')
<li class="breadcrumb-item"><a href="{{ url('/panel/institutions?per_page=6') }}">Institutos</a></li>
@endsection

@section('contenido')

<div class="row">
  <div class="col-md-12">
    <div class="tile">

      <h3 class="tile-title">Complete los siguientes campos</h3>
      <div class="tile-body">

        @if(isset($institution))
          {!! Form::model($institution, ['route' => ['institutions.update', $institution->id], 'method' => 'PUT','enctype' => 'multipart/form-data']) !!}
        @else
          {!! Form::open(['action' => 'Institution\InstitutionController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        @endif

        @csrf

          <div class="form-group">
            <label for="name" class="control-label">Nombre</label>
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Escriba el nombre del instituto']); !!}
          </div>

          <div class="form-group">
            <label for="acronym" class="control-label">Siglas</label>
            {!! Form::text('acronym', null, ['class' => 'form-control', 'placeholder' => 'Escriba las siglas del instituto']); !!}
          </div>

          <div class="form-group">
            <label for="description" class="control-label">Descripción</label>
            {!! Form::textarea('description' , null , ['class' => 'form-control']) !!}
          </div>

          <div class="form-group">
            <label for="address" class="control-label">Dirección</label>
            {!! Form::textarea('address' , null , ['class' => 'form-control']) !!}
          </div>

          <div class="form-group">
            <label for="file" class="control-label">Selecciona un logo</label>
            {!! Form::file('file'); !!}
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
