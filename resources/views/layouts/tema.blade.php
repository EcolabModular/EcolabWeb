<!DOCTYPE html>
<html lang="es">

<head>
  <title>Ecolab</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
  <!-- Font-icon css-->
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

</head>

<body class="app sidebar-mini rtl">
  <!-- Navbar-->
  <header class="app-header"><a class="app-header__logo" href="{{ url('/inicio') }}">Ecolab</a>
    <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
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
        <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="{{ asset('img/' .Auth::user()->photo)}}" alt="User Image" width="40" height="40">
          <div>
            <p class="app-sidebar__user-name">{{ Auth::user()->name }}</p>
            <p class="app-sidebar__user-designation">{{ Auth::user()->email }}</p>
          </div>
        </div>
      @endif

  @include('layouts.menu')
  </aside>
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><img src="{{ asset('img/logo.png') }}"  width="30" height="30" alt="Ecolab"/>@yield('titulo_contenido')</h1>
        @yield('subtitulo_contenido')
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ url('/panel')}}">Inicio</a></li>
        <li class="breadcrumb-item">@yield('ruta_ref')</li>
      </ul>
    </div>
    @yield('contenido')
  </main>
  <!-- Essential javascripts for application to work-->
  <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
  <script src="{{ asset('js/popper.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>
  <!-- The javascript plugin to display page loading on top-->
  <script src="{{ asset('js/plugins/pace.min.js') }}"></script>
  <!-- Page specific javascripts-->
</body>

</html>
