@extends('layouts.tema')

@section('titulo_contenido')
    @if(isset($item))
        Editar Item
    @else
        Registrar Item
    @endif
@endsection
@section('subtitulo_contenido')
    @if(isset($item))
        Editar Item: {{$item->name}}
    @else
        Registrar Item en el Sistema
    @endif
@endsection
@section('ruta_ref') <a href="{{ url('/admin/items') }}">Items</a> @endsection

@section('contenido')

<div class="row">
  <div class="col-md-12">
    <div class="tile">

      <h3 class="tile-title">Complete los siguientes campos</h3>
      <div class="tile-body">

        @if(isset($item))
          {!! Form::model($item, ['route' => ['items.update', $item->id], 'method' => 'PUT','enctype' => 'multipart/form-data']) !!}
        @else
          {!! Form::open(['action' => 'Item\ItemController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        @endif

        @csrf

          <div class="form-group">
            <label for="name" class="control-label">Nombre</label>
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Escriba el nombre del item']); !!}
          </div>

          <div class="form-group">
            <label for="description" class="control-label">Descripción</label>
            {!! Form::textarea('description' , null , ['class' => 'form-control']) !!}
          </div>

          <div class="form-group">
            <label for="laboratory_id" class="control-label">Laboratorio</label>
            {!! Form::select('laboratory_id',  $laboratoriesArray, null, ['class' => 'form-control', 'placeholder' => 'Selecciona un laboratorio...']) !!}
          </div>

          <div class="form-group">
            <label for="file" class="control-label">Selecciona una imagen</label>
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
