@extends('layouts.tema')
@section('contenido')
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<strong>Ups! Algo Salió mal...</strong> Tu sesión ha expirado, por favor refresca la pagina e intenta de nuevo.
	</div>
	<button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Inicio</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="{{ url('/') }}">
@endsection