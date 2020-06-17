@extends('layouts.tema')

@section('titulo_contenido') Mostrar Item @endsection
@section('subtitulo_contenido') Item registrado en el sistema ECOLAB @endsection
@section('rutas')
<li class="breadcrumb-item"><a href="{{ url('/panel/items?per_page=6') }}">Items</a></li>
<li class="breadcrumb-item"><a href="{{ url("/panel/items/".$item->id ) }}">{{$item->id}}</a></li>
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

<div class="container-fluid">
    <div class="row">
        <div class="col-4">
            <a href="{{ route('items.create') }}" class="btn btn-primary btn-block">CREAR NUEVO ITEM</a>
                <div class="card">
                    <img src="{{$item->imgItem}}" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">{{$item->name}}</h5>
                        <p class="card-text">Descripción: {{$item->description}}</p>
                        <p class="card-text">Laboratorio: {{$laboratory->name}}</p>
                        <img src="{{$item->qrcode}}" class="card-img-overlay">
                        <a href="#" class="btn btn-primary">Imprimir QR Code</a>
                        <div class="btn-group pull-right">
                        <a class="btn btn-primary" href="{{ route('items.edit', $item->id) }}">Editar <i class="fa fa-lg fa-edit"></i></a>
                        {!!Form::open(['action'=>['Item\ItemController@destroy', $item->id], 'method'=>'DELETE', 'style' => 'display: inline-block;'])!!}
                            @csrf
                            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-trash-o"></i>Eliminar</button>

                         {!! Form::close() !!}
                        </div>

                        <p class="card-footer">Creado: {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:m')}}<br>
                            Actualizado: {{ \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y H:m')}}</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
