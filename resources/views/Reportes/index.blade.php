@extends('layouts.tema')
@section('titulo_contenido') Listado de Reportes @endsection
@section('subtitulo_contenido') Reportes Registrados en el Sistema ECOLAB @endsection
@section('ruta_ref') <a href="{{ url('/reports') }}">Laboratorios</a> @endsection
@section('contenido')

@if(!isset($reports))
<div class="alert-warning">
  No Hay Reportes Registrados
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
    <h3 class="tile-title">REPORTES</h3>
    <a href="{{ route('reports.create')}}" class="btn btn-block btn-primary">NUEVO REPORTE</a>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>NOMBRE</th>
          <th>DESCRIPCIÓN</th>
          <th>ESTATUS</th>
          <th>TIPO</th>
          <th>CREADO</th>
          <th>ACTUALIZADO</th>
        </tr>
      </thead>
      <tbody>
        @foreach($reports as $reporte)
        <tr>
          <td>
            <a class="btn btn-sm btn-primary" href="{{ route('reports.show', $reporte->id) }}">{{ $reporte->id }}</a>
          </td>
          <td>{{ $reporte->name}}</td>
          <td>{{ $reporte->description }}</td>
          <td>{{ $reporte->status }}</td>
          <td>{{ $reporte->reportType_id}}</td>
          <td>{{ \Carbon\Carbon::parse($reporte->created_at)->format('d/m/Y') }}</td>
          <td>{{ \Carbon\Carbon::parse($reporte->updated_at)->format('d/m/Y')}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
