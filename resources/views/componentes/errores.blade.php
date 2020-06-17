@if(isset($errors) && sizeof($errors) > 0)
<link rel="stylesheet" type="text/css" href="{{ asset('css/errors.css') }}" >

    @if($errors->all()[1] == "500")
    <div class="page-error tile">
        <h1>Ups! Something Went Wrong...</h1>
        <section class="error-container">
            <span>5</span>
            <span><span class="screen-reader-text">0</span></span>
            <span>0</span>
        </section>
        <h1>{{$errors->all()[0]}}</h1>
    </div>
    @elseif($errors->all()[1] == "404")
    <div class="page-error tile">
        <h1>Ups! Something Went Wrong...</h1>
        <section class="error-container">
            <span>4</span>
            <span><span class="screen-reader-text">0</span></span>
            <span>4</span>
        </section>
        <h1>{{$errors->all()[2]}}</h1>
    </div>
    @else
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h1>Ups! Something Went Wrong...</h1>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

    @endif
@endif
@if(session()->has('success'))
    <div class="alert alert-success">
        <button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button>
            <ul>
            @foreach(session()->get('success') as $message)
                <li>{{$message}}</li>
            @endforeach
        </ul>
    </div>
@endif
