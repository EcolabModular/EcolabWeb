@extends('layouts.tema')
@section('titulo_contenido') Nota Registrado @endsection
@section('subtitulo_contenido') Nota Registrado en el Sistema ECOLAB @endsection
@section('rutas')
<li class="breadcrumb-item"><a href="{{ url('/panel/notes') }}">Notas</a></li>
<li class="breadcrumb-item"><a href="{{ url("/panel/notes/".$note->id ) }}">{{$note->id}}</a></li>
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
            <a href="{{ route('notes.create') }}" class="btn btn-primary btn-block">CREAR NUEVA NOTA</a>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{$note->name}}</h4>
                        <h5 class="card-text">Item: <a href="{{ route('items.show',$item->id) }}">{{$item->name}}</a></h5>
                        <h5 class="card-text">Descripción:</h5><p>{{$note->description}}</p>

                        <div class="btn-group pull-right">
                            <a class="btn btn-primary" href="{{ route('notes.edit', $note->id) }}"><i class="fa fa-lg fa-edit"></i>Editar</a>
                            {!!Form::open(['action'=>['Note\NoteController@destroy', $note->id], 'method'=>'DELETE', 'style' => 'display: inline-block;'])!!}
                                @csrf
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-trash-o"></i>Eliminar</button>
                            {!! Form::close() !!}
                        </div>
                        <br>
                        <br>
                        <p class="card-footer">Creado: {{ \Carbon\Carbon::parse($note->created_at)->format('d/m/Y H:m')}}<br>Actualizado: {{ \Carbon\Carbon::parse($note->updated_at)->format('d/m/Y H:m')}}</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
