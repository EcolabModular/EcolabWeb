@extends('layouts.tema')
@section('titulo_contenido') Usuario Registrado @endsection
@section('subtitulo_contenido') Usuario Registrado en el Sistema ECOLAB @endsection
@section('ruta_ref') <a href="{{ url('/users') }}">Usuarios</a> @endsection

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
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-block">CREAR NUEVO USUARIO</a>
                <div class="card">
                    {{--<img src="{{$user->photo}}" class="card-img-top">--}}
                    <div class="card-body">
                        <h5 class="card-title">{{$user->name . " " . $user->lastname}}</h5>
                        <p class="card-text">Rol de usuario: {{$userType->dictionaryType}}</p>
                        <p class="card-text">Institución: {{$institution->name}}</p>

                        {{--<img src="{{$item->qrcode}}" class="card-img-overlay"> --}}
                        <div class="btn-group pull-right">
                            <a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}"><i class="fa fa-lg fa-edit"></i>Editar</a>
                            {!!Form::open(['action'=>['User\UserController@destroy', $user->id], 'method'=>'DELETE', 'style' => 'display: inline-block;'])!!}
                                @csrf
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-trash-o"></i>Eliminar</button>
                            {!! Form::close() !!}
                        </div>
                        <br>
                        <br>
                        <p class="card-footer">Creado: {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y')}}<br>Actualizado: {{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y')}}</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<br>
<br>
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="tile-title-w-btn">
        <h3 class="title">{{$user->name}}</h3>

        <div class="btn-group">
            <a class="btn btn-primary" href="{{ route('users.create') }}"><i class="fa fa-lg fa-plus"></i></a>
            <a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}"><i class="fa fa-lg fa-edit"></i></a>
            {!!Form::open(['action'=>['User\UserController@destroy', $user->id], 'method'=>'DELETE', 'style' => 'display: inline-block;'])!!}
            @csrf
            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-trash-o"></i></button>
            {!! Form::close() !!}
        </div>

      </div>
      <div class="tile-body">
        <div class="table table-responsive">
          <table class="table table-hover">
            <thead>
              <th>NOMBRE</th>
              <th>CORREO</th>
              <th>CODIGO</th>

            </thead>
            <tbody>
              <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->code }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
