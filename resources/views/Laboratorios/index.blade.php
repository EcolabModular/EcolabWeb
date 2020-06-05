@extends('layouts.tema')
@section('titulo_contenido') Listado de Laboratorios @endsection
@section('subtitulo_contenido') Laboratorios Registrados en el Sistema ECOLAB @endsection
@section('ruta_ref') <a href="{{ url('/laboratories') }}">Laboratorios</a> @endsection
@section('contenido')

@if(!isset($laboratories))
<div class="alert-warning">
  No Hay Laboratorios Registrados
</div>
@endif

@if(isset($success))
<div class="alert alert-success">
    <button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button>
    <ul>
        <li>{{$success}}</li>
    </ul>
</div>
@endif

<div class="table table-bordered table-responsive">
  <div class="tile">
    <h3 class="tile-title">LABORATORIOS</h3>
    <a href="{{ route('laboratories.create')}}" class="btn btn-block btn-primary">NUEVO LABORATORIO</a>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>NOMBRE</th>
          <th>DESCRIPCIÓN</th>
          <th>INSTITUTO</th>
          <th>CREADO</th>
          <th>ACTUALIZADO</th>
        </tr>
      </thead>
      <tbody>
        @foreach($laboratories as $laboratorio)
        <tr>
          <td>
            <a class="btn btn-sm btn-primary" href="{{ route('laboratories.show', $laboratorio->id) }}">{{ $laboratorio->id }}</a>
          </td>
          <td>{{ $laboratorio->name}}</td>
          <td>{{ $laboratorio->description }}</td>
          <td>{{ $laboratorio->institution_id }}</td>
          <td>{{ $laboratorio->created_at }}</td>
          <td>{{ \Carbon\Carbon::parse($laboratorio->updated_at)->format('d/m/Y')}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
