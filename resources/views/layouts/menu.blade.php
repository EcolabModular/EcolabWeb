<ul class="app-menu">

  <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-calendar"></i><span class="app-menu__label">Laboratorios</span><i class="treeview-indicator fa fa-angle-right"></i></a>
    <ul class="treeview-menu">
      <li><a class="treeview-item" href="{{ route('laboratories.index') }}"><i class="icon fa fa-list-ol"></i>Listar Laboratorios</a></li>
    </ul>
  </li>

  <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-calendar"></i><span class="app-menu__label">Items</span><i class="treeview-indicator fa fa-angle-right"></i></a>
    <ul class="treeview-menu">
      <li><a class="treeview-item" href="{{ route('items.index') }}"><i class="icon fa fa-list-ol"></i>Listar Items</a></li>
      <li><a class="treeview-item" href="{{ route('items.create') }}"><i class="icon fa fa-pencil"></i>Crear Item</a></li>
    </ul>
  </li>

  <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-calendar"></i><span class="app-menu__label">Reportes</span><i class="treeview-indicator fa fa-angle-right"></i></a>
    <ul class="treeview-menu">
      <li><a class="treeview-item" href="{{ route('reports.index') }}"><i class="icon fa fa-list-ol"></i>Listar Reportes</a></li>
    </ul>
  </li>

  <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-user"></i><span class="app-menu__label">Usuarios</span><i class="treeview-indicator fa fa-angle-right"></i></a>
    <ul class="treeview-menu">
      <li><a class="treeview-item" href="{{ route('users.index') }}"><i class="icon fa fa-list-ol"></i>Listar Usuarios</a></li>
      <li><a class="treeview-item" href="{{ route('users.create') }}"><i class="icon fa fa-pencil"></i>Crear Usuario</a></li>
    </ul>
  </li>
</ul>
