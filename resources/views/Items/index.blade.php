@extends('layouts.tema')
@section('titulo_contenido') Listado de Items @endsection
@section('subtitulo_contenido') Items Registrados en el Sistema @endsection
@section('ruta_ref') <a href="{{ url('/admin') }}">Items</a> @endsection
@section('contenido')

@if(isset($success))
<div class="alert alert-success">
    <button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button>
    <ul>
        <li>{{$success}}</li>
    </ul>
</div>
@endif

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
                            <p class="card-footer"></p>

                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
