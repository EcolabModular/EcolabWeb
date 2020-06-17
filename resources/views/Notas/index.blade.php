@extends('layouts.tema')
@section('titulo_contenido') Listado de Notas @endsection
@section('subtitulo_contenido') Notas Registrados en el Sistema ECOLAB @endsection
@section('rutas')
<li class="breadcrumb-item"><a href="{{ url('/panel/notes') }}">Notas</a></li>
@endsection
@section('contenido')

@if(!isset($notes))
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
    <h3 class="tile-title">NOTAS</h3>
    <a href="{{ route('notes.create')}}" class="btn btn-block btn-primary">NUEVA NOTA</a>

    <br>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="dataTables_length" id="sampleTable_length">
                <label>Mostrar <select id="selectPaginate" name="sampleTable_length" aria-controls="sampleTable" class="form-control form-control-md">
                    <option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option>
                </select> entradas</label>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div id="sampleTable_filter" class="dataTables_filter"><label>Buscar:<input id="inputSearch" type="search" class="form-control form-control-md" placeholder="Buscar" aria-controls="sampleTable"></label>
            </div>
        </div>
    </div>

    <table class="table table-hover table-bordered dataTable no-footer">
      <thead>
        <tr>
            <th id="id_sort" class="sorting">ID</th>
            <th id="name_sort" class="sorting" style="width: 100px;">NOMBRE</th>
            <th>DESCRIPCIÓN</th>
            <th id="item_sort" class="sorting">ITEM</th>
            <th id="created_sort" class="sorting">CREADO</th>
            <th id="updated_sort" class="sorting">ACTUALIZADO</th>
        </tr>
      </thead>
      <tbody>
        @foreach($notes as $nota)
        <tr>
          <td>
            <a class="btn btn-sm btn-primary" href="{{ route('notes.show', $nota->id) }}">{{ $nota->id }}</a>
          </td>
          <td>{{ $nota->name}}</td>
          <td>{{ $nota->description }}</td>
          <td>{{ $nota->item_id }}</td>
          <td>{{ \Carbon\Carbon::parse($nota->created_at)->format('d/m/Y H:m') }}</td>
          <td>{{ \Carbon\Carbon::parse($nota->updated_at)->format('d/m/Y H:m')}}</td>
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
                        <li class="paginate_button page-item previous"><a href="{{ url("/panel/notes?".$page_url.$previous_page ) }}" aria-controls="sampleTable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>
                    @endif
                    @for($i=1;$i<=$numOfpages;$i++)
                        @if($current_page == $i)
                            <li class="paginate_button page-item active"><a href="{{ url("/panel/notes?".$page_url.$i ) }}" aria-controls="sampleTable" data-dt-idx="1" tabindex="0" class="page-link">{{$i}}</a></li>
                        @else
                            <li class="paginate_button page-item"><a href="{{ url("/panel/notes?".$page_url.$i) }}" aria-controls="sampleTable" data-dt-idx="1" tabindex="0" class="page-link">{{$i}}</a></li>
                        @endif
                    @endfor
                    @if($next_page > $numOfpages)
                        <li class="paginate_button page-item next disabled"><a href="#" aria-controls="sampleTable" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li>
                    @else
                        <li class="paginate_button page-item next"><a href="{{ url("/panel/notes?".$page_url.$next_page ) }}" aria-controls="sampleTable" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li>
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

    $("#id_sort").click(function(){
        if($.urlParam('sort_by') == "id"){
            window.location.replace("/panel/notes?per_page="+per_page);
        }else{
            window.location.replace("/panel/notes?per_page="+per_page+"&sort_by=id");
        }
    });

    $("#name_sort").click(function(){
        if($.urlParam('sort_by') == "name"){
            window.location.replace("/panel/notes?per_page="+per_page);
        }else{
            window.location.replace("/panel/notes?per_page="+per_page+"&sort_by=name");
        }
    });
    $("#created_sort").click(function(){
        if($.urlParam('sort_by') == "created_at"){
            window.location.replace("/panel/notes?per_page="+per_page);
        }else{
            window.location.replace("/panel/notes?per_page="+per_page+"&sort_by=created_at");
        }
    });
    $("#updated_sort").click(function(){
        if($.urlParam('sort_by') == "updated_at"){
            window.location.replace("/panel/notes?per_page="+per_page);
        }else{
            window.location.replace("/panel/notes?per_page="+per_page+"&sort_by=updated_at");
        }
    });

    $("#item_sort").click(function(){
        if($.urlParam('sort_by') == "item_id"){
            window.location.replace("/panel/notes?per_page="+per_page);
        }else{
            window.location.replace("/panel/notes?per_page="+per_page+"&sort_by=item_id");
        }
    });

    $(document).keyup(function(event) {
    if ($("#inputSearch").is(":focus") && event.key == "Enter") {
        busqueda = $("#inputSearch").val();
        window.location.replace("/panel/notes?per_page="+per_page+"&name="+busqueda);
    }
    });
    $("#selectPaginate").change(function(){
        pagination = $("#selectPaginate option:selected").val();
        window.location.replace("/panel/notes?per_page="+pagination);
    });

    $.urlParam = function(name){
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results==null) {
            return null;
        }
        return decodeURI(results[1]) || 0;
    }
</script>
@endsection
