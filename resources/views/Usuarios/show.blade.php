@extends('layouts.tema')
@section('titulo_contenido') Usuario Registrado @endsection
@section('subtitulo_contenido') Usuario Registrado en el Sistema ECOLAB @endsection
@section('ruta_ref') <a href="{{ url('/users') }}">Usuarios</a> @endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="tile-title-w-btn">
        <h3 class="title">{{$usuario->nombre}}</h3>
        @php $imgraw = str_replace('?dl=0', '?raw=1', $usuario->urlimg) @endphp
        <div class="btn-group">
          <a class="btn btn-primary" href="{{ route('users.create') }}"><i class="fa fa-lg fa-plus"></i></a>
          <a class="btn btn-primary" href="{{ route('users.edit', $usuario->identificador) }}"><i class="fa fa-lg fa-edit"></i></a>
        </div>
      </div>
      <div class="tile-body">
        <div class="table table-responsive">
          <table class="table table-hover">
            <thead>
              <th>NOMBRE</th>
              <th>CORREO</th>
              <th>CODIGO</th>
              <th>FOTO</th>
            </thead>
            <tbody>
              <tr>
                <td>{{ $usuario->nombre }}</td>
                <td>{{ $usuario->correo }}</td>
                <td>{{ $usuario->codigo }}</td>
                <td> <img class="app-sidebar__user-avatar" src="{{ $imgraw }}" alt="User Image" width="40" height="40"> </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="clearfix"></div>

  <div class="col-md-12">
    <div class="tile">
      <h3 class="tile-title">Reportes del Usuario</h3>
      <div class="table table-bordered table-responsive">
        <table class="table table-hover">
          <thead>
        <tr>
          <th>#</th>
          <th>TITULO</th>
          <th>DESCRIPCIÓN</th>
          <th>CANTIDAD</th>
          <th>ICON</th>
          <th>PDF</th>
          <th>STATUS</th>
          <th>SOLICITUD</th>
          <th>UPDATED_AT</th>
        </tr>
      </thead>
      <tbody>
        @foreach($reportes as $reporte)
        @php $imgraw = str_replace('?dl=0', '?raw=1', $reporte->urlimg) @endphp
        <tr>
          <td>
            <a class="btn btn-sm btn-info" href="{{ route('reports.show', $reporte->identificador) }}">{{ $reporte->identificador }}
            </a>
          </td>
          <td>{{ $reporte->titulo }}</td>
          <td>{{ $reporte->descripcion }}</td>
          <td>{{ $reporte->cantidad }}</td>
          <td> <img class="app-sidebar__user-avatar" src="{{ $imgraw }}" alt="User Image" width="40" height="40"> </td>
          <td>{{ $reporte->fichero }}</td>
          <td>{{ $reporte->estatus }}</td>
          <td>{{ $reporte->pedido }}</td>
          <td>{{ $reporte->fechaActualizacion }}</td>
        </tr>
        @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
@endsection
