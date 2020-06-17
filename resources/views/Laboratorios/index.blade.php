@extends('layouts.tema')
@section('titulo_contenido') Listado de Laboratorios @endsection
@section('subtitulo_contenido') Laboratorios Registrados en el Sistema ECOLAB @endsection
@section('rutas')
<li class="breadcrumb-item"><a href="{{ url('/panel/laboratories') }}">Notas</a></li>
@endsection
@section('contenido')

@if(!isset($laboratories))
<div class="alert-warning">
  No Hay Laboratorios Registrados
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
<div class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
  <div class="tile">
    <h3 class="tile-title">LABORATORIOS</h3>
    <a href="{{ route('laboratories.create')}}" class="btn btn-block btn-primary">NUEVO LABORATORIO</a>
    <br>

    <div class="row">
        <div class="col-sm-2 col-md-4">
            <div class="dataTables_length">
                <label>Mostrar
                <select id="selectPaginate" name="sampleTable_length" aria-controls="sampleTable" class="form-control">
                    <option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option>
                </select> entradas</label>
            </div>
        </div>

        <div class="col-sm-4 col-md-4">
            <input id="inputSearch" type="search" class="form-control" placeholder="Buscar" aria-controls="sampleTable">
        </div>

        <div class="col-sm-4 col-md-4">
            <select id="selectFilter" class="form-control">
                <option disabled selected>Filtrar por Universidad</option>
                @foreach ($institutionsArray as $index => $value)
                    <option value={{$index}}>{{$value}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <table class="table table-hover table-bordered dataTable no-footer">
      <thead>
        <tr>
          <th>ID</th>
          <th>NOMBRE</th>
          <th>DESCRIPCIÓN</th>
          <th>INSTITUTO</th>
          <th>CREADO</th>
          <th>ACTUALIZADO</th>
        </tr>
      </thead>
      <tbody>
        @foreach($laboratories as $laboratorio)
        <tr>
          <td>
            <a class="btn btn-sm btn-primary" href="{{ route('laboratories.show', $laboratorio->id) }}">{{ $laboratorio->id }}</a>
          </td>
          <td>{{ $laboratorio->name}}</td>
          <td>{{ $laboratorio->description }}</td>
          <td>{{ $laboratorio->institution_id }}</td>
          <td>{{ \Carbon\Carbon::parse($laboratorio->created_at)->format('d/m/Y H:m') }}</td>
          <td>{{ \Carbon\Carbon::parse($laboratorio->updated_at)->format('d/m/Y H:m')}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="row">
        <div class="col-sm-12 col-md-5">
            <div class="dataTables_info" role="status" aria-live="polite">Mostrando {{ $from }} to {{ $to }} of {{ $total}}</div>
        </div>
        <div class="col-sm-12 col-md-7">
            <div class="dataTables_paginate paging_simple_numbers">
                <ul class="pagination">
                    @if($previous_page < 1)
                        <li class="paginate_button page-item previous disabled"><a href="#" aria-controls="sampleTable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>
                    @else
                        <li class="paginate_button page-item previous"><a href="{{ url("/panel/laboratories?".$page_url.$previous_page ) }}" aria-controls="sampleTable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>
                    @endif
                    @for($i=1;$i<=$numOfpages;$i++)
                        @if($current_page == $i)
                            <li class="paginate_button page-item active"><a href="{{ url("/panel/laboratories?".$page_url.$i ) }}" aria-controls="sampleTable" data-dt-idx="1" tabindex="0" class="page-link">{{$i}}</a></li>
                        @else
                            <li class="paginate_button page-item"><a href="{{ url("/panel/laboratories?".$page_url.$i) }}" aria-controls="sampleTable" data-dt-idx="1" tabindex="0" class="page-link">{{$i}}</a></li>
                        @endif
                    @endfor
                    @if($next_page > $numOfpages)
                        <li class="paginate_button page-item next disabled"><a href="#" aria-controls="sampleTable" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li>
                    @else
                        <li class="paginate_button page-item next"><a href="{{ url("/panel/laboratories?".$page_url.$next_page ) }}" aria-controls="sampleTable" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li>
                    @endif
                </ul>
            </div>
        </div>
      </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
    var per_page = "<?php echo $per_page; ?>";

    $(document).keyup(function(event) {
    if ($("#inputSearch").is(":focus") && event.key == "Enter") {
        busqueda = $("#inputSearch").val();
        window.location.replace("/panel/laboratories?per_page="+per_page+"&name="+busqueda);
    }
    });
    $("#selectPaginate").change(function(){
        pagination = $("#selectPaginate option:selected").val();
        window.location.replace("/panel/laboratories?per_page="+pagination);
    });

    $("#selectFilter").change(function(){
    sortLab = $("#selectFilter option:selected").val();
    window.location.replace("/panel/laboratories?per_page="+per_page+"&institution_id="+sortLab);
});

</script>
@endsection
