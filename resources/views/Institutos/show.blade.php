@extends('layouts.tema')

@section('titulo_contenido') Mostrar Universidad @endsection
@section('subtitulo_contenido') Universidad registrada en el sistema ECOLAB @endsection
@section('rutas')
<li class="breadcrumb-item"><a href="{{ url('/panel/institutions?per_page=6') }}">Universidades</a></li>
<li class="breadcrumb-item"><a href="{{ url("/panel/institutions/".$institution->id ) }}">{{$institution->id}}</a></li>
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
            <a href="{{ route('institutions.create') }}" class="btn btn-primary btn-block">CREAR NUEVA UNIVERSIDAD</a>
                <div class="card">
                    <img src="{{$institution->logo}}" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">{{$institution->name}}</h5>
                        <p class="card-text">{{$institution->description}}</p>
                        <p class="card-text">{{$institution->address}}</p>
                        <div class="btn-group pull-right">
                        <a class="btn btn-primary" href="{{ route('institutions.edit', $institution->id) }}">Editar <i class="fa fa-lg fa-edit"></i></a>
                        {!!Form::open(['action'=>['Institution\InstitutionController@destroy', $institution->id], 'method'=>'DELETE', 'style' => 'display: inline-block;'])!!}
                            @csrf
                            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-trash-o"></i>Eliminar</button>
                         {!! Form::close() !!}
                        </div>
                        <br><br>
                        <p class="card-footer">Creado: {{ \Carbon\Carbon::parse($institution->created_at)->format('d/m/Y H:m')}}<br>
                            Actualizado: {{ \Carbon\Carbon::parse($institution->updated_at)->format('d/m/Y H:m')}}</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
