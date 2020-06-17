@extends('layouts.tema')
@section('contenido')
<link rel="stylesheet" type="text/css" href="{{ asset('css/errorsx.css') }}" >
<div class="page-error tile">
    <div id="clouds">
        <div class="cloud x1"></div>
        <div class="cloud x1_5"></div>
        <div class="cloud x2"></div>
        <div class="cloud x3"></div>
        <div class="cloud x4"></div>
        <div class="cloud x5"></div>
    </div>
    <div class='c'>
        <div class='_404'>503</div>
        <hr>
        <div class='_1'>The server is under maintenance.</div>
        <div class='_2'>Come back later...</div>
        <a class='btn' href='#'>BACK TO HOME</a>
    </div>
</div>
@endsection
