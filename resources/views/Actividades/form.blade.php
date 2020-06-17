@extends('layouts.tema')
@section('titulo_contenido') Rellene los Campos para una Actividad @endsection
@section('subtitulo_contenido') Formulario para registro una actividad @endsection
@section('rutas')
<li class="breadcrumb-item"><a href="{{ url('/panel/calendarios') }}">Actividades</a></li>
@endsection

@section('contenido')

<div class="row">

    <div class="col-md-12 sticky-top alert alert-dismissible" id="alerts"></div>

    <div class="col-md-12">
      <div class="tile">

        <h3 class="tile-title">Rellene los Campos para una Actividad</h3>
        <div class="tile-body">

            @if(isset($schedulary))
                {!! Form::model($schedulary, ['route' => ['schedularies.update', $schedulary->id], 'method' => 'PUT']) !!}
            @else
                {!! Form::open(['route' => 'schedularies.store']) !!}
            @endif

                @csrf

                <div id="idSelectReporte" class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <h5>Selecciona Tipo de Reporte</h5>
                            {!! Form::select('reportType_id',  $typeArray, null, ['class' => 'form-control', 'placeholder' => 'Selecciona tipo de reporte...','id'=>'selectFilterTipo']) !!}
                        </div>
                    </div>
                </div>

                <div id="containerReport" class="col-md-12">

                    <div class="row">
                        <div class="col-md-12">
                            <input id="inputSearch" type="search" class="form-control" placeholder="Buscar" aria-controls="sampleTable">
                        </div>
                    </div>

                    <div class="tile">
                        <div id="overlayLoading2" class="overlay">
                            <div class="m-loader mr-4">
                              <svg class="m-circular" viewBox="25 25 50 50">
                                  <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                              </svg>
                            </div>
                            <h3 class="l-text">Cargando</h3>
                        </div>
                      <h3 id="reportTitle" class="tile-title"></h3>
                      <table  id="reportTable" class="table table-hover">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>NOMBRE</th>
                            <th>DESCRIPCIÓN</th>
                            <th>TIPO</th>
                            <th>ESTATUS</th>
                            <th>CREADO</th>
                            <th>SELECCIONAR</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers">
                                <ul id="pagination" class="pagination">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


            <br>
                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <h5>Laboratorio</h5>
                            {!! Form::select('laboratory_id',  $laboratoriesArray, null, ['id'=>'selectLaboratory','class' => 'form-control', 'placeholder' => 'Selecciona un laboratorio...']) !!}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="tile-body">
                            <h5>Item</h5>
                            <select id="selectItem" name="item_id" aria-controls="sampleTable" class="form-control">
                                <option disabled selected>Selecciona Item</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="tile-body">
                            <h5>Reporte Actual</h5>
                            <h5 id="reporteActual">NO SELECCIONADO</h5>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="tile-body">
                            <h5>Desvincular Reporte Actual</h5>
                            <a href="#" id="cancelarReporte" class="btn btn-block btn-warning btn-block"><i class="fa fa-trash"></i>CANCELAR</a>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-3">
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

                    <div class="col-sm-3">
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

                    <div class="col-md-3">
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

                    <div class="col-sm-3">
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

                <br>

                <div class="tile-footer">
                    <a href="#" id="registrarActividad" class="btn btn-block btn-primary btn-block"><i class="fa fa-fw fa-lg fa-check-circle"></i>CONTINUAR</a>
                    <input type="hidden" name="_token" id="tokenUser" value="{{ Auth::user()->access_token}}">
                    <input type="hidden" id="baseUrlGate" value="{{ Config::get('services.ecolab.base_uri') }}">
                </div>

          {!! Form::close() !!}
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
    var baseUrl = "<?php  ?>";
</script>
<script src="{{ asset('js/Reporte/reporteCalendarioCreate.js') }}"></script>
@stop

