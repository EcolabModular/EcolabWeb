@extends('layouts.tema')
@section('titulo_contenido') Reporte Registrado @endsection
@section('subtitulo_contenido') Reporte Registrado en el Sistema ECOLAB @endsection
@section('rutas')
<li class="breadcrumb-item"><a href="{{ url('/panel/reports') }}">Reportes</a></li>
<li class="breadcrumb-item"><a href="{{ url("/panel/reports/".$report->id ) }}">{{$report->id}}</a></li>
@endsection
@section('headers')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('contenido')

@if(isset($success))
<div class="alert alert-success">
    <button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button>
    <ul>
        <li>{{$success}}</li>
    </ul>
</div>
@endif

<div class="col-md-12 sticky-top alert alert-dismissible" id="alerts"></div>

<div class="container-fluid">
    <div class="row">
        <div class="col-6">
            <a href="{{ route('reports.create') }}" class="btn btn-primary btn-block">CREAR NUEVO REPORTE</a>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{$report->name}}</h4>
                        <h5 class="card-text">{{$report->reportType_id}}</h5>
                        <h5 class="card-text">Reporte {{$report->status}}</h5>
                        <h5 class="card-text">Descripción:</h5><p>{{$report->description}}</p>
                        <div class="btn-group pull-right">
                            <a class="btn btn-primary" href="{{ route('reports.edit', $report->id) }}"><i class="fa fa-lg fa-edit"></i>Editar</a>
                            {!!Form::open(['action'=>['Report\ReportController@destroy', $report->id], 'method'=>'DELETE', 'style' => 'display: inline-block;'])!!}
                                @csrf
                                <button class="btn btn-danger" type="submit"><i class="fa fa-fw fa-lg fa-trash-o"></i>Eliminar</button>
                            {!! Form::close() !!}
                        </div>
                        <br>
                        <br>
                        <p class="card-footer">Creado: {{ \Carbon\Carbon::parse($report->created_at)->format('d/m/Y')}}
                            <br>Actualizado: {{ \Carbon\Carbon::parse($report->updated_at)->format('d/m/Y')}}</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
