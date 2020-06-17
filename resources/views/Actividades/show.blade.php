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

        <div class="col-md-6">

            <button id="agregarItem" class="btn btn-primary btn-block">ASIGNAR REPORTE A ITEM</button>

            <div id="containerReport" class="tile">
                <h3 class="tile-title">COMPLETA LOS SIGUIETES CAMPOS</h3>
                <div class="tile-body">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="tile-body">
                                <h5>Laboratorio</h5>
                                <select id="selectLaboratory" class="form-control">
                                    <option disabled selected>Selecciona Laboratorio</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="tile-body">
                                <h5>Item</h5>
                                <select id="selectItem" class="form-control">
                                    <option disabled selected>Selecciona Item</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="tile-body">
                                <h5>Fecha Inicio</h5>
                                <div class="input-group date">
                                    <input class="form-control" id="demoDate1" name="fechaInicio" type="text" placeholder="Selecciona Fecha Inicio">
                                    <div class="input-group-append">
                                        <div id="demeDateTrigger1" class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <h5>Hora Inicio</h5>
                            <div class="form-group">
                                <div class="input-group date" id="datetimepicker3" data-target-input="nearest">
                                    <input id="horaInicio" type="text" name="horaInicio" placeholder="Selecciona Hora Inicio" class="form-control datetimepicker-input" data-target="#datetimepicker3"/>
                                    <div class="input-group-append" data-target="#datetimepicker3" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="tile-body">
                                <h5>Fecha Final</h5>
                                <div class="input-group date">
                                    <input class="form-control" id="demoDate2" name="fechaFinal" type="text" placeholder="Selecciona Fecha Final">
                                    <div class="input-group-append">
                                        <div id="demeDateTrigger2" class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <h5>Hora Final</h5>
                            <div class="form-group">
                                <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                                    <input id="horaFinal" type="text" name="horaFinal" placeholder="Selecciona Hora Final" class="form-control datetimepicker-input" data-target="#datetimepicker4"/>
                                    <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <button id="guardar" class="btn btn-primary col-6">GUARDAR</button>
                        <button id="cancelar" class="btn btn-danger col-6">CANCELAR</button>
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    var baseUrl = "<?php echo url('/'); ?>";
</script>
<script>
    var reportID = "<?php echo $report->id; ?>";
</script>
<script src="{{ asset('js/Reporte/reporteShow.js') }}"></script>
@stop
