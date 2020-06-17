@extends('layouts.tema')
@section('contenido')
<link rel="stylesheet" type="text/css" href="{{ asset('css/error419.css') }}" >
<div class="page-error tile">
    <h1 class="h1-error">Ups! Something Went Wrong...</h1>
    <section class="error-container">
        <span>4</span>
        <span>1</span>
        <span>9</span>
    </section>
    <h1 class="h1-error">The session has expired. Logging again...</h1>
    <div class="link-container">
        <a class="btn btn-primary" href="{{ route('login') }}"><i class="fa fa-sign-in"></i>LOGIN</a>
    </div>
    @if(isset($onlyErrors))
    <h1 class="h1-error">Errors:</h1>
        @foreach ($onlyErrors as $item)
            <h2 class="h2-error">- {{$item}}</h2>
        @endforeach
    @endif
</div>
@endsection
