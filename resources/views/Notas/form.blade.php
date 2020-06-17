@extends('layouts.tema')

@section('titulo_contenido')
    @if(isset($note))
        Editar Nota
    @else
        Registrar Nota
    @endif
@endsection
@section('subtitulo_contenido')
    @if(isset($note))
        Editar Nota: {{$note->name}}
    @else
        Registrar Nota en el Sistema
    @endif
@endsection
@section('rutas')
<li class="breadcrumb-item"><a href="{{ url('/panel/notes') }}">Notas</a></li>
@endsection

@section('contenido')

<div class="row">
  <div class="col-md-12">
    <div class="tile">

      <h3 class="tile-title">Complete los siguientes campos</h3>
      <div class="tile-body">

        @if(isset($note))
          {!! Form::model($note, ['route' => ['notes.update', $note->id], 'method' => 'PUT']) !!}
        @else
          {!! Form::open(['action' => 'Note\NoteController@store', 'method' => 'POST']) !!}
        @endif

        @csrf

          <div class="form-group">
            <label for="name" class="control-label">Titulo</label>
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Escriba el titulo de la nota']); !!}
          </div>

          <div class="form-group">
            <label for="description" class="control-label">Descripción</label>
            {!! Form::textarea('description' , null , ['class' => 'form-control']) !!}
          </div>

          <div class="form-group">
            <label for="item_id" class="control-label">Item</label>
            {!! Form::select('item_id',  $itemsArray, null, ['class' => 'form-control', 'placeholder' => 'Selecciona un item...']) !!}
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
