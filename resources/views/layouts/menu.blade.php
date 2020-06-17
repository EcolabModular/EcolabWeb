<ul class="app-menu">

    <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-flask"></i><span class="app-menu__label">Universidades</span><i class="treeview-indicator fa fa-angle-right"></i></a>
        <ul class="treeview-menu">
          <li><a class="treeview-item" href="{{ route('institutions.index') }}"><i class="icon fa fa-list-ol"></i>Listar Universidades</a></li>
          <li><a class="treeview-item" href="{{ route('institutions.create') }}"><i class="icon fa fa-pencil"></i>Crear universidad</a></li>
        </ul>
    </li>

  <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-flask"></i><span class="app-menu__label">Laboratorios</span><i class="treeview-indicator fa fa-angle-right"></i></a>
    <ul class="treeview-menu">
      <li><a class="treeview-item" href="{{ route('laboratories.index') }}"><i class="icon fa fa-list-ol"></i>Listar Laboratorios</a></li>
      <li><a class="treeview-item" href="{{ route('laboratories.create') }}"><i class="icon fa fa-pencil"></i>Crear Laboratorio</a></li>
    </ul>
  </li>

  <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-tasks"></i><span class="app-menu__label">Actividades</span><i class="treeview-indicator fa fa-angle-right"></i></a>
    <ul class="treeview-menu">
      <li><a class="treeview-item" href="{{ route('schedularies.create') }}"><i class="icon fa fa-tasks"></i>Crear Actividad</a></li>
    </ul>
  </li>

  <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-cubes"></i><span class="app-menu__label">Items</span><i class="treeview-indicator fa fa-angle-right"></i></a>
    <ul class="treeview-menu">
      <li><a class="treeview-item" href="{{ url("/panel/items?per_page=6") }}"><i class="icon fa fa-list-ol"></i>Listar Items</a></li>
      <li><a class="treeview-item" href="{{ route('items.create') }}"><i class="icon fa fa-pencil"></i>Crear Item</a></li>
    </ul>
  </li>

  <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-files-o"></i><span class="app-menu__label">Reportes</span><i class="treeview-indicator fa fa-angle-right"></i></a>
    <ul class="treeview-menu">
      <li><a class="treeview-item" href="{{ route('reports.index') }}"><i class="icon fa fa-list-ol"></i>Listar Reportes</a></li>
      <li><a class="treeview-item" href="{{ route('reports.create') }}"><i class="icon fa fa-pencil"></i>Crear Reporte</a></li>
      <li><a class="treeview-item" href="{{ route('reports.create') }}"><i class="icon fa fa-clock-o"></i>Crear Reporte Predictivo</a></li>
    </ul>
  </li>

  <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-commenting-o"></i><span class="app-menu__label">Notas</span><i class="treeview-indicator fa fa-angle-right"></i></a>
    <ul class="treeview-menu">
      <li><a class="treeview-item" href="{{ route('notes.index') }}"><i class="icon fa fa-list-ol"></i>Listar Notas</a></li>
      <li><a class="treeview-item" href="{{ route('notes.create') }}"><i class="icon fa fa-pencil"></i>Crear Nota</a></li>
    </ul>
  </li>

  <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-calendar"></i><span class="app-menu__label">Calendario</span><i class="treeview-indicator fa fa-angle-right"></i></a>
    <ul class="treeview-menu">
      <li><a class="treeview-item" href="{{ route('calendarios') }}"><i class="icon fa fa-calendar-check-o"></i>Mostrar Actividades</a></li>
    </ul>
  </li>

  <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-line-chart"></i><span class="app-menu__label">Estadisticas</span><i class="treeview-indicator fa fa-angle-right"></i></a>
    <ul class="treeview-menu">
      <li><a class="treeview-item" href="{{ route('predictivo') }}"><i class="icon fa fa-bar-chart"></i>Mantenimientos Mensuales</a></li>
      <li><a class="treeview-item" href="{{ route('reports.index') }}"><i class="icon fa fa-bar-chart"></i>Mantenimientos Semanales</a></li>
      <li><a class="treeview-item" href="{{ route('reports.index') }}"><i class="icon fa fa-bar-chart"></i>Reporte de Rendimiento</a></li>
    </ul>
  </li>

  <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-user"></i><span class="app-menu__label">Usuarios</span><i class="treeview-indicator fa fa-angle-right"></i></a>
    <ul class="treeview-menu">
      <li><a class="treeview-item" href="{{ route('users.index') }}"><i class="icon fa fa-list-ol"></i>Listar Usuarios</a></li>
      <li><a class="treeview-item" href="{{ route('users.create') }}"><i class="icon fa fa-pencil"></i>Crear Usuario</a></li>
    </ul>
  </li>
</ul>
