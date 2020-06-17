<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ecolab</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->

    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>



    @yield('headers')

</head>
<body class="app sidebar-mini rtl">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="{{ url('/panel') }}">Ecolab</a>
        <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar"
            aria-label="Hide Sidebar"></a>
        <!-- Navbar Right Menu-->
        <ul class="app-nav">
            <li class="app-search">
                <input class="app-search__input" type="search" placeholder="Search">
                <button class="app-search__button"><i class="fa fa-search"></i></button>
            </li>
            @if(Auth::check())
                @include('layouts.usuario_menu')
            @else
                <a class="app-nav__item" href="{{ route('login') }}"><i class="fa fa-sign-in"></i></a>
            @endif
        </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
        @if(Auth::check())
            <div class="app-sidebar__user">
                <div>
                    <p class="app-sidebar__user-name">{{ Auth::user()->name}}</p>
                    <p class="app-sidebar__user-designation">{{ Auth::user()->usertype}}</p>
                </div>
            </div>
        @endif
        @include('layouts.menu')
    </aside>
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><img src="{{ asset('img/logo.png') }}" width="30" height="30"
                        alt="Ecolab" />@yield('titulo_contenido','Bienvenid@')</h1>
                @yield('subtitulo_contenido','Sistema de Gestión de Laboratorios')
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ url('/panel') }}">Inicio</a></li>
                @yield('rutas')
                {{--
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ url('/panel') }}">Inicio</a></li>
                <li class="breadcrumb-item">@yield('ruta_ref')</li>
                <li class="breadcrumb-item">@yield('ruta_ref_sub')</li>
                --}}
            </ul>
        </div>
        @include('componentes.errores')
        @yield('contenido')
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="{{ asset('js/plugins/pace.min.js') }}"></script>
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>


    @yield('scripts')
</body>

</html>
