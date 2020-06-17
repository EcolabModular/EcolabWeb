@extends('layouts.tema')
@section('contenido')
<link rel="stylesheet" type="text/css" href="{{ asset('css/errors.css') }}" >
<div class="page-error tile">
    <h1 class="h1-error">Ups! Something Went Wrong...</h1>
    <section class="error-container">
        <span>5</span>
        <span><span class="screen-reader-text">0</span></span>
        <span>0</span>
    </section>
    <br>
    <h1 class="h1-error">An internal server error has occurred. Come back later...</h1>
    @if(isset($onlyErrors))
    <h1 class="h1-error">Erros:</h1>
        @foreach ($onlyErrors as $item)
            <h2 class="h2-error">- {{$item}}</h2>
        @endforeach
    @endif
</div>
@endsection
