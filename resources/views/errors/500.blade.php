@extends('layouts.tema')
@section('contenido')
<link rel="stylesheet" type="text/css" href="{{ asset('css/errors.css') }}" >
<h1>Ups! Something Went Wrong...</h1>
<section class="error-container">
    <span>5</span>
    <span><span class="screen-reader-text">0</span></span>
    <span>0</span>
</section>
<h1>An internal server error has occurred. Come back later...</h1>
@endsection
