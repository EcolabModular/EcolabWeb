@extends('layouts.tema')
@section('titulo_contenido') Rellene los campos para reporte @endsection
@section('subtitulo_contenido') Formulario para registro de reportes @endsection
@section('rutas')
<li class="breadcrumb-item"><a href="{{ url('/panel/reports') }}">Reportes</a></li>
@endsection

@section('contenido')

<div class="row">

    <div class="col-md-12 sticky-top alert alert-dismissible" id="alerts"></div>

    <div class="col-md-12">
      <div class="tile">

        <h3 class="tile-title">Rellene los Campos para Reporte</h3>
        <div class="tile-body">

            @if(isset($report))
                {!! Form::model($report, ['route' => ['reports.update', $report->id], 'method' => 'PUT']) !!}
            @else
                {!! Form::open(['route' => 'reports.store']) !!}
            @endif

                @csrf

                {{--{{dd($report)}} --}}

                <div class="form-group">
                    <h5>Titulo</h5>
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Escriba el titulo del reporte']); !!}
                </div>

                <div class="form-group">
                    <h5>Descripción</h5>
                    {!! Form::textarea('description' , null , ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    <h5>Selecciona Estatus</h5>
                    @if(!isset($report))
                        {!! Form::radio('status', 'regular'); !!} <label for="status" class="control-label">Regular</label><br>
                        {!! Form::radio('status', 'urgente'); !!} <label for="status" class="control-label">Urgente</label><br>
                    @else
                        {!! Form::select('status',  $typeArrayStatus, null, ['class' => 'form-control', 'placeholder' => 'Selecciona status del reporte...']) !!}
                    @endif
                </div>

                <br>
                <div class="form-group">
                    <h5>Selecciona Tipo de Reporte</h5>
                    {!! Form::select('reportType_id',  $typeArray, null, ['class' => 'form-control', 'placeholder' => 'Selecciona tipo de reporte...','id'=>'reportType_id']) !!}
                </div>

                <div class="tile-footer">
                    <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>CONTINUAR</button>
                </div>

          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection
