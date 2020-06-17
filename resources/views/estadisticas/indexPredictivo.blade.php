@extends('layouts.tema')
@section('titulo_contenido') Analisis Predictivo @endsection
@section('subtitulo_contenido') Reporte de analisis predictivo @endsection
@section('contenido')

<div class="row">

    <div class="col-md-10">
          <figure class="highcharts-figure">
            <div id="container1"></div>
          </figure>
    </div>

    <div class="col-md-10">
        <figure class="highcharts-figure">
          <div id="container2"></div>
        </figure>
  </div>

</div>

@endsection
@section('scripts')
@parent
<script>
    var baseUrl = "<?php echo url('/'); ?>";
</script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="{{ asset('js/Estadisticas/estadisticas.js') }}"></script>
@stop
