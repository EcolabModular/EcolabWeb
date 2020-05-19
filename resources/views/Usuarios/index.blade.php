@extends('layouts.tema')
@section('titulo_contenido') Listado de Usuarios @endsection
@section('subtitulo_contenido') Usuarios Registrados en el Sistema ECOLAB @endsection
@section('ruta_ref') <a href="{{ url('/users') }}">Usuarios</a> @endsection
@section('contenido')

@if($usuarios->count() == 0)
<div class="alert-warning">
  No Hay Usuarios Registrados
</div>
@endif
<div class="table table-bordered table-responsive">
  <div class="tile">
    <h3 class="tile-title">Usuarios</h3>
    <a href="{{ route('users.create')}}" class="btn btn-success">Nuevo Usuario</a>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>NOMBRE</th>
          <th>CORREO</th>
          <th>CÓDIGO</th>
          <th>TELÉFONO</th>
          <th>TIPO</th>
          <th>VERIFICADO</th>
          <th>FOTO</th>
          <th>CREACIÓN</th>
          <th>ACTUALIZACIÓN</th>
        </tr>
      </thead>
      <tbody>
        @foreach($usuarios as $usuario)
        @php $imgraw = str_replace('?dl=0', '?raw=1', $usuario->urlimg) @endphp
        <tr>
          <td>
            <a class="btn btn-sm btn-info" href="{{ route('users.show', $usuario->identificador) }}">{{ $usuario->identificador }}</a>
          </td>
          <td>{{ $usuario->nombre }}</td>
          <td>{{ $usuario->correo }}</td>
          <td>{{ $usuario->codigo }}</td>
          <td>{{ $usuario->telefono }}</td>
          <td>{{ $usuario->tipo }}</td>
          <td>{{ $usuario->esVerificado }}</td>
          <td> <img class="app-sidebar__user-avatar" src="{{ $imgraw }}" alt="User Image" width="40" height="40"> </td>
          <td>{{ $usuario->fechaCreacion }}</td>
          <td>{{ $usuario->fechaActualizacion }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
