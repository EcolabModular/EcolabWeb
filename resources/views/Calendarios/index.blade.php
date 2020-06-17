@extends('layouts.tema')
@section('titulo_contenido') Calendario de Actividades @endsection
@section('subtitulo_contenido') Reportes registrados en el calendario @endsection
@section('rutas')
<li class="breadcrumb-item"><a href="{{ url('/panel/schedularies') }}">Calendario</a></li>
@endsection
@section('contenido')

<div class="row">

    <div class="col-md-12 sticky-top alert alert-dismissible" id="alerts"></div>

    <div id="containerItem" class="col-md-6">
        <div class="tile">
            <div id="overlayLoading1" class="overlay">
                <div class="m-loader mr-4">
                  <svg class="m-circular" viewBox="25 25 50 50">
                      <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                  </svg>
                </div>
                <h3 class="l-text">Cargando</h3>
            </div>
          <h3 id="itemTitle" class="tile-title"></h3>
          <table  id="itemTable" class="table table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>DESCRIPCIÓN</th>
                <th>LABORATORIO</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>

    <div class="clearfix"></div>

    <div id="containerReport" class="col-md-6">
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
                <th>DESCRIPCIÓN</th>
                <th>TIPO</th>
                <th>ESTATUS</th>
                <th>INICIO</th>
                <th>FIN</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    <div class="clearfix"></div>

    <div id="containerNote" class="col-md-12">
        <div class="tile">
            <div id="overlayLoading3" class="overlay">
                <div class="m-loader mr-4">
                  <svg class="m-circular" viewBox="25 25 50 50">
                      <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                  </svg>
                </div>
                <h3 class="l-text">Cargando</h3>
            </div>
          <h3 class="tile-title">Notas del Item</h3>
          <table  id="noteTable" class="table table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>DESCRIPCIÓN</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>

    <div class="clearfix"></div>

    <div class="col-md-12">
        <div class="tile">

            <div class="tile-title-w-btn">
                <h3 class="title">Filtrado de Actividades</h3>
            </div>

            <div class="row">

                <div class="col-md-3">
                    <div class="tile-body">
                        <h5>Seleccionar Universidad*</h5>
                        <select id="selectFilterUniversidad" name="sampleTable_length" aria-controls="sampleTable" class="form-control"></select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="tile-body">
                        <h5>Seleccionar Laboratorio*</h5>
                        <select id="selectFilterLab" name="sampleTable_length" aria-controls="sampleTable" class="form-control"></select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="tile-body">
                        <h5>Filtrar Por Item</h5>
                        <select id="selectFilterItem" name="sampleTable_length" aria-controls="sampleTable" class="form-control"></select>
                    </div>
                </div>

                <div class="col-md-3">
                    <h5>Universidad Actual:</h5>
                    <h5 id="universidadActual"></h5>
                </div>

            </div>

            <br>

            <div class="row">

                <div class="col-md-4">
                    <div class="tile-body">
                        <h5>Filtrar Por Fecha Inicio</h5>
                        <input class="form-control" id="demoDate1" type="text" placeholder="Selecciona Fecha">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="tile-body">
                        <h5>Filtrar Por Tipo de Reporte</h5>
                        <select id="selectFilterTipo" name="sampleTable_length" aria-controls="sampleTable" class="form-control">
                            <option disabled selected>Selecciona tipo de reporte</option>
                            <option value="1">PREVENTIVO</option><option value="2">CORRECTIVO</option><option value="3">PREDICTIVO</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="tile-body">
                        <h5>Filtrar Por Estatus de Reporte</h5>
                        <select id="selectFilterEstatus" name="sampleTable_length" aria-controls="sampleTable" class="form-control">
                            <option disabled selected>Selecciona tipo de estatus</option>
                            <option value="urgente">URGENTE</option><option value="regular">REGULAR</option><option value="atendido">ATENDIDO</option>
                            <option value="cancelado">CANCELADO</option>
                            <option value="archivado">ARCHIVADO</option>
                        </select>
                    </div>
                </div>

            </div>

            <br>

            <div class="row">
                <div class="col-md-4">
                    <div id="overlayLoadingTotal" class="overlay">
                        <div class="m-loader mr-4">
                          <svg class="m-circular" viewBox="25 25 50 50">
                              <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                          </svg>
                        </div>
                        <h3 class="l-text">Cargando</h3>
                    </div>
                    <div class="tile-body">
                        <h5>Total Actividades:</h5>
                        <h5 id="total"></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="col-md-12">
      <div class="tile row">
        <div id="overlayLoading" class="overlay">
            <div class="m-loader mr-4">
              <svg class="m-circular" viewBox="25 25 50 50">
                  <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
              </svg>
            </div>
            <h3 class="l-text">Cargando</h3>
        </div>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />
        <div class="col-md-12">
          <div id="calendar"></div>
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
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
<script src="{{ asset('js/Calendario/calendarioData.js') }}"></script>
@stop
