@extends('layouts.tema')
@section('titulo_contenido') Listado de Usuarios @endsection
@section('subtitulo_contenido') Usuarios Registrados en el Sistema ECOLAB @endsection
@section('ruta_ref') <a href="{{ url('/users') }}">Usuarios</a> @endsection
@section('contenido')

@if(!isset($usuarios))
<div class="alert-warning">
  No Hay Usuarios Registrados
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
    <h3 class="tile-title">USUARIOS</h3>
    <a href="{{ route('users.create')}}" class="btn btn-block btn-primary">NUEVO USUARIO</a>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>NOMBRE</th>
          <th>CORREO</th>
          <th>CÓDIGO</th>
          <th>TELÉFONO</th>
          <th>CREADO</th>
          <th>ACTUALIZADO</th>
        </tr>
      </thead>
      <tbody>
        @foreach($usuarios as $usuario)
        <tr>
          <td>
            <a class="btn btn-sm btn-primary" href="{{ route('users.show', $usuario->id) }}">{{ $usuario->id }}</a>
          </td>
          <td>{{ $usuario->name . " " . $usuario->lastname}}</td>
          <td>{{ $usuario->email }}</td>
          <td>{{ $usuario->code }}</td>
          <td>{{ $usuario->phone }}</td>
          <td>{{ \Carbon\Carbon::parse($usuario->created_at)->format('d/m/Y ')}}</td>
          <td>{{ \Carbon\Carbon::parse($usuario->updated_at)->format('d/m/Y')}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
