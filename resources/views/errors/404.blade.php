@extends('layouts.tema')
@section('contenido')

<link rel="stylesheet" type="text/css" href="{{ asset('css/errors.css') }}" >

<h1>Ups! Something Went Wrong...</h1>
<section class="error-container">
  <span>4</span>
  <span><span class="screen-reader-text">0</span></span>
  <span>4</span>
</section>
<h1>El recurso que has intentado solicitar no se encuentra en el sitio.</h1>
@endsection
