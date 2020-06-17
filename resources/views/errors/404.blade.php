@extends('layouts.tema')
@section('contenido')

<link rel="stylesheet" type="text/css" href="{{ asset('css/errors.css') }}" >
<div class="page-error tile">
    <h1 class="h1-error">Ups! Something Went Wrong...</h1>
    <section class="error-container">
    <span>4</span>
    <span><span class="screen-reader-text">0</span></span>
    <span>4</span>
    </section>
    @if(isset($message))
        <h1 class="h1-error">{{$message}}</h1>
    @endif
    @if(isset($onlyErrors))
    <h1 class="h1-error">Errors:</h1>
        @foreach ($onlyErrors as $item)
            <h2 class="h2-error">- {{$item}}</h2>
        @endforeach
    @endif
</div>
@endsection
