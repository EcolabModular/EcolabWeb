@extends('layouts.tema')
@section('titulo_contenido') Listado de Universidades @endsection
@section('subtitulo_contenido') Universidades Registradas en el Sistema @endsection
@section('rutas')
<li class="breadcrumb-item"><a href="{{ url('/panel/institutions?per_page=5') }}">Universidades</a></li>
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

<div class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
    <div class="tile">
      <h3 class="tile-title">UNIVERSIDADES</h3>
      <a href="{{ route('institutions.create')}}" class="btn btn-block btn-primary">NUEVA UNIVERSIDAD</a>
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
            <select id="selectSorting" class="form-control">
                <option disabled selected>Ordenar Universidades</option>
                <option value="id">ID</option><option value="name">NOMBRE</option><option value="created_at">CREACION</option><option value="updated_at">ACTUALIZACION</option>
            </select>
        </div>
    </div>
<div class="container-fluid">
    <div class="row">
        @foreach($institutions as $institution)
            <div class="col-4">
                <a href="{{ route('institutions.show', $institution->id) }}">
                    <div class="card">
                        <img src="{{$institution->logo}}" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">{{$institution->name}}</h5>
                            <p class="card-text">{{$institution->description}}</p>
                            <p class="card-text">{{$institution->address}}</p>
                            <p class="card-footer">Creado: {{ \Carbon\Carbon::parse($institution->created_at)->format('d/m/Y H:m')}}<br>
                                Actualizado: {{ \Carbon\Carbon::parse($institution->updated_at)->format('d/m/Y H:m')}}</p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
<br>
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
                    <li class="paginate_button page-item previous"><a href="{{ url("/panel/institutions?".$page_url.$previous_page ) }}" aria-controls="sampleTable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>
                @endif
                @for($i=1;$i<=$numOfpages;$i++)
                    @if($current_page == $i)
                        <li class="paginate_button page-item active"><a href="{{ url("/panel/institutions?".$page_url.$i ) }}" aria-controls="sampleTable" data-dt-idx="1" tabindex="0" class="page-link">{{$i}}</a></li>
                    @else
                        <li class="paginate_button page-item"><a href="{{ url("/panel/institutions?".$page_url.$i) }}" aria-controls="sampleTable" data-dt-idx="1" tabindex="0" class="page-link">{{$i}}</a></li>
                    @endif
                @endfor
                @if($next_page > $numOfpages)
                    <li class="paginate_button page-item next disabled"><a href="#" aria-controls="sampleTable" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li>
                @else
                    <li class="paginate_button page-item next"><a href="{{ url("/panel/institutions?".$page_url.$next_page ) }}" aria-controls="sampleTable" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li>
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
    window.location.replace("/panel/institutions?per_page="+per_page+"&name="+busqueda);
}
});

$("#selectPaginate").change(function(){
    pagination = $("#selectPaginate option:selected").val();
    window.location.replace("/panel/institutions?per_page="+pagination);
});

$("#selectSorting").change(function(){
    sort = $("#selectSorting option:selected").val();
    window.location.replace("/panel/institutions?per_page="+per_page+"&sort_by="+sort);
});
</script>
@endsection

