@extends('layouts.tema')
@section('titulo_contenido') Listado de Items @endsection
@section('subtitulo_contenido') Items Registrados en el Sistema @endsection
@section('rutas')
<li class="breadcrumb-item"><a href="{{ url('/panel/items?per_page=6') }}">Items</a></li>
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
      <h3 class="tile-title">ITEMS</h3>
      <a href="{{ route('items.create')}}" class="btn btn-block btn-primary">NUEVO ITEM</a>
      <br>
    <div class="row">
        <div class="col-sm-2 col-md-2">
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

        <div class="col-sm-4 col-md-3">
            <select id="selectSorting" class="form-control">
                <option disabled selected>Ordenar Items</option>
                <option value="id">ID</option><option value="name">NOMBRE</option><option value="created_at">CREACION</option><option value="updated_at">ACTUALIZACION</option>
            </select>
        </div>
        <div class="col-sm-4 col-md-3">
            <select id="selectSortingLab" class="form-control">
                <option disabled selected>Filtrar por Laboratorio</option>
                @foreach ($laboratoriesArray as $index => $value)
                    <option value={{$index}}>{{$value}}</option>
                @endforeach
            </select>
        </div>
    </div>
<div class="container-fluid">
    <div class="row">
        @foreach($items as $item)
            <div class="col-4">
                <a href="{{ route('items.show', $item->id) }}">
                    <div class="card">
                        <img src="{{$item->imgItem}}" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">{{$item->name}}</h5>
                            <p class="card-text">{{$item->description}}</p>
                            <img src="{{$item->qrcode}}" class="card-img-overlay">
                            <a href="#" class="btn btn-primary">Imprimir QR Code</a>
                            <p class="card-footer">Creado: {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:m')}}<br>
                                Actualizado: {{ \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y H:m')}}</p>
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
                    <li class="paginate_button page-item previous"><a href="{{ url("/panel/items?".$page_url.$previous_page ) }}" aria-controls="sampleTable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>
                @endif
                @for($i=1;$i<=$numOfpages;$i++)
                    @if($current_page == $i)
                        <li class="paginate_button page-item active"><a href="{{ url("/panel/items?".$page_url.$i ) }}" aria-controls="sampleTable" data-dt-idx="1" tabindex="0" class="page-link">{{$i}}</a></li>
                    @else
                        <li class="paginate_button page-item"><a href="{{ url("/panel/items?".$page_url.$i) }}" aria-controls="sampleTable" data-dt-idx="1" tabindex="0" class="page-link">{{$i}}</a></li>
                    @endif
                @endfor
                @if($next_page > $numOfpages)
                    <li class="paginate_button page-item next disabled"><a href="#" aria-controls="sampleTable" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li>
                @else
                    <li class="paginate_button page-item next"><a href="{{ url("/panel/items?".$page_url.$next_page ) }}" aria-controls="sampleTable" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li>
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
    window.location.replace("/panel/items?per_page="+per_page+"&name="+busqueda);
}
});
$("#selectPaginate").change(function(){
    pagination = $("#selectPaginate option:selected").val();
    window.location.replace("/panel/items?per_page="+pagination);
});

$("#selectSorting").change(function(){
    sort = $("#selectSorting option:selected").val();
    window.location.replace("/panel/items?per_page="+per_page+"&sort_by="+sort);
});

$("#selectSortingLab").change(function(){
    sortLab = $("#selectSortingLab option:selected").val();
    window.location.replace("/panel/items?per_page="+per_page+"&laboratory_id="+sortLab);
});
</script>
@endsection

