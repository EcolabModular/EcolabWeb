@extends('layouts.tema')
@section('titulo_contenido') Laboratorio Registrado @endsection
@section('subtitulo_contenido') Laboratorio Registrado en el Sistema ECOLAB @endsection
@section('rutas')
<li class="breadcrumb-item"><a href="{{ url('/panel/laboratories') }}">Laboratorios</a></li>
<li class="breadcrumb-item"><a href="{{ url("/panel/laboratories/".$laboratory->id ) }}">{{$laboratory->id}}</a></li>
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
        <div class="col-12">
            <a href="{{ route('laboratories.create') }}" class="btn btn-primary btn-block">CREAR NUEVO LABORATORIO</a>
                <div class="card">
                    {{--<img src="{{$user->photo}}" class="card-img-top">--}}
                    <div class="card-body">
                        <h5 class="card-title">{{$laboratory->name}}</h5>
                        <p class="card-text">Institución: {{$institution->name}}</p>
                        <p class="card-text">Descripción: <br>{{$laboratory->description}}</p>

                        {{--<img src="{{$item->qrcode}}" class="card-img-overlay"> --}}
                        <div class="btn-group pull-right">
                            <a class="btn btn-primary" href="{{ route('laboratories.edit', $laboratory->id) }}"><i class="fa fa-lg fa-edit"></i>Editar</a>
                            {!!Form::open(['action'=>['Laboratory\LaboratoryController@destroy', $laboratory->id], 'method'=>'DELETE', 'style' => 'display: inline-block;'])!!}
                                @csrf
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-trash-o"></i>Eliminar</button>
                            {!! Form::close() !!}
                        </div>
                        <br>
                        <br>
                        <p class="card-footer">Creado: {{ \Carbon\Carbon::parse($laboratory->created_at)->format('d/m/Y H:m')}}<br>Actualizado: {{ \Carbon\Carbon::parse($laboratory->updated_at)->format('d/m/Y H:m')}}</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
