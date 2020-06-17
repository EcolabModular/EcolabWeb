@extends('layouts.tema')
@section('titulo_contenido') Rellene los campos para usuarios @endsection
@section('subtitulo_contenido') Formulario para registro de usuarios @endsection
@section('rutas')
<li class="breadcrumb-item"><a href="{{ url('/panel/users') }}">Usuarios</a></li>
@endsection

@section('contenido')
<div class="row">
    <div class="col-md-12">
      <div class="tile">

        <h3 class="tile-title">Rellene los Campos para Usuario</h3>
        <div class="tile-body">

            @if(isset($user))
                {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT']) !!}
            @else
                {!! Form::open(['route' => 'users.store']) !!}
            @endif

                @csrf

                <div class="form-group">
                <label for="name" class="control-label">Nombre</label>
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Escriba el nombre del usuario']); !!}
                </div>

                <div class="form-group">
                    <label for="lastname" class="control-label">Apellidos</label>
                    {!! Form::text('lastname', null, ['class' => 'form-control', 'placeholder' => 'Escriba los apellidos del usuario']); !!}
                </div>

                <div class="form-group">
                    <label for="code" class="control-label">Código de estudiante</label>
                    {!! Form::text('code', null, ['class' => 'form-control', 'placeholder' => 'Escriba el codigo del usuario']); !!}
                </div>

                <div class="form-group">
                    <label for="email" class="control-label">Correo de estudiante</label>
                    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Escriba el correo del usuario']); !!}
                </div>

                <div class="form-group">
                    <label for="password" class="control-label">Contraseña</label>
                    {{ Form::password('password', array('placeholder'=>'Escriba la contraseña del usuario', 'class'=>'form-control' ))}}
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="control-label">Confirmar Contraseña</label>
                    {{ Form::password('password_confirmation', array('placeholder'=>'Confirmar Contraseña', 'class'=>'form-control' ))}}
                </div>

                <div class="form-group">
                    <label for="gender" class="control-label">Selecciona Sexo</label><br>
                    {!! Form::radio('gender', 'F'); !!} <label for="" class="control-label">Mujer</label><br>
                    {!! Form::radio('gender', 'M'); !!} <label for="" class="control-label">Hombre</label><br>
                </div>

                <div class="form-group">
                    <label for="userType" class="control-label">Rol de Usuario</label>
                    {!! Form::select('userType',  $userTypeArray, null, ['class' => 'form-control', 'placeholder' => 'Selecciona un rol de usuario...']) !!}
                </div>

                <div class="form-group">
                    <label for="institution_id" class="control-label">Selecciona una Institución</label>
                    {!! Form::select('institution_id',  $institutionsArray, null, ['class' => 'form-control', 'placeholder' => 'Selecciona una Institución...']) !!}
                </div>

                <div class="tile-footer">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>CONTINUAR</button>
                </div>

          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection
