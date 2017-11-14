<!DOCTYPE html>
<html ng-app="app">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="shortcut icon" type="image/png" href="/img/favicon.png"/>
    
    <title>@yield('title') | Lembrar</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/dist/css/skins/_all-skins.min.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- iziToast -->
    <link rel="stylesheet" href="/bower_components/iziToast/css/iziToast.min.css">
    <!-- sweet alert -->
    <link rel="stylesheet" href="/bower_components/sweet-alert/sweetalert.css">
    <!-- app -->
    <link rel="stylesheet" href="/dist/css/app.css">
    <!-- jQuery 3 -->
    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/bower_components/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.7 -->
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- daterangepicker -->
    <script src="/bower_components/moment/moment.min.js"></script>
    <script src="/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="/bower_components/bootstrap-datepicker/dist/js/app.js"></script>
    <!-- AdminLTE App -->
    <script src="/dist/js/adminlte.min.js"></script>
    <!-- iziToast -->
    <script src="/bower_components/iziToast/js/iziToast.min.js"></script>
    <!-- igorescobar/jQuery-Mask-Plugin -->
    <script src="/bower_components/jquery-mask-plugin/jQuery Mask Plugin v1.14.11.js"></script>
    <!-- sweet alert -->
    <script src="/bower_components/sweet-alert/sweetalert.min.js"></script>
    <!-- angular -->
    <script src="/bower_components/angular/AngularJSv1.6.5.js"></script>
    <script src="/bower_components/angular/services/app.ngmask.module.js"></script>
    <script src="/bower_components/angular/directives/app.directives.js"></script>

    <script>
      var myApp = angular.module('myApp', ['ngResource']);

      myApp.config(['$httpProvider', function ($httpProvider) {
        $httpProvider.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
      }]);
    </script>   

  </head>
  <body class="hold-transition skin-black sidebar-collapse sidebar-mini">
    @if (Session::has('flash_message'))
      <script>
        iziToast.{{ strtolower(Session::get('flash_message_level')) }}({
          title: '{{ Session::get('flash_message_level') == 'success' ? 'Pronto!' : (Session::get('flash_message_level') == 'warning' ? 'Cuidado!' : 'Ops!') }}',
          message: '{{ Session::get('flash_message') }}',
          position: 'topRight',
          timeout: '{{ Session::get('flash_message_level') == 'success' ? '5000' : '7000' }}',
        });
      </script>
      @endif
    
    <div class="wrapper">
      <header class="main-header">
        <!-- Logo -->
        <a href="/master" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">L<b>BR</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">Lem<b>brar</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-envelope-o"></i>
                  <!-- <span class="label label-success">4</span> -->
                </a>
                <ul class="dropdown-menu">
                  <!-- <li class="header">You have 4 messages</li>
                  <li>
                    inner menu: contains the actual data
                    <ul class="menu">
                      <li>start message
                      <a href="#">
                        <div class="pull-left">
                          <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                        </div>
                        <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                      </a>
                    </li>
                    end message
                    <li>
                      <a href="#">
                        <div class="pull-left">
                          <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                        </div>
                        <h4>
                        AdminLTE Design Team
                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <div class="pull-left">
                          <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                        </div>
                        <h4>
                        Developers
                        <small><i class="fa fa-clock-o"></i> Today</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <div class="pull-left">
                          <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                        </div>
                        <h4>
                        Sales Department
                        <small><i class="fa fa-clock-o"></i> Yesterday</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <div class="pull-left">
                          <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                        </div>
                        <h4>
                        Reviewers
                        <small><i class="fa fa-clock-o"></i> 2 days</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                      </a>
                    </li>
                  </ul>
                                  </li>
                                  <li class="footer"><a href="#">See All Messages</a></li> -->
              </ul>
            </li>
            <!-- Notifications: style can be found in dropdown.less -->
            <li class="dropdown notifications-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <span class="label label-warning">10</span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">You have 10 notifications</li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu">
                    <li>
                      <a href="#">
                        <i class="fa fa-users text-aqua"></i> 5 new members joined today
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                        page and may cause design problems
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="fa fa-users text-red"></i> 5 new members joined
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="fa fa-user text-red"></i> You changed your username
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="footer"><a href="#">View all</a></li>
              </ul>
            </li>
            <!-- Tasks: style can be found in dropdown.less -->
            <li class="dropdown tasks-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-flag-o"></i>
                <span class="label label-danger">9</span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">You have 9 tasks</li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu">
                    <li><!-- Task item -->
                    <a href="#">
                      <h3>
                      Design some buttons
                      <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                          aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                  <a href="#">
                    <h3>
                    Create a nice theme
                    <small class="pull-right">40%</small>
                    </h3>
                    <div class="progress xs">
                      <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
                        aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                        <span class="sr-only">40% Complete</span>
                      </div>
                    </div>
                  </a>
                </li>
                <!-- end task item -->
                <li><!-- Task item -->
                <a href="#">
                  <h3>
                  Some task I need to do
                  <small class="pull-right">60%</small>
                  </h3>
                  <div class="progress xs">
                    <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"
                      aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                      <span class="sr-only">60% Complete</span>
                    </div>
                  </div>
                </a>
              </li>
              <!-- end task item -->
              <li><!-- Task item -->
              <a href="#">
                <h3>
                Make beautiful transitions
                <small class="pull-right">80%</small>
                </h3>
                <div class="progress xs">
                  <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"
                    aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                    <span class="sr-only">80% Complete</span>
                  </div>
                </div>
              </a>
            </li>
            <!-- end task item -->
          </ul>
        </li>
        <li class="footer">
          <a href="#">View all tasks</a>
        </li>
      </ul>
    </li>
    <!-- User Account: style can be found in dropdown.less -->
    <li class="dropdown user user-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <img src="/img/master/users/avatar_{{ Auth::id() }}.jpg" class="user-image" alt="User Image">
        <span class="hidden-xs">{{ Auth::user()->name }}</span>
      </a>
      <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header">
          <img src="/img/master/users/avatar_{{ Auth::id() }}.jpg" class="img-circle" alt="User Image">
          <p>
            {{ Auth::user()->name }}
          </p>
        </li>
        <!-- Menu Body -->
        <li class="user-body">
          <div class="row">
            <div class="col-xs-4 text-center">
              <a href="#">Followers</a>
            </div>
            <div class="col-xs-4 text-center">
              <a href="#">Sales</a>
            </div>
            <div class="col-xs-4 text-center">
              <a href="#">Friends</a>
            </div>
          </div>
          <!-- /.row -->
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
          <div class="pull-left">
            <a href="#" class="btn btn-default btn-flat">Profile</a>
          </div>
          <div class="pull-right">
            <form id="form-logout" method="POST" action="/master/logout">
              {{ csrf_field() }}
            </form>
            <a href="#" class="btn btn-default btn-flat" onclick="document.getElementById('form-logout').submit()">
              Sign out
            </a>
          </div>
        </li>
      </ul>
    </li>
  </ul>
</div>
</nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
<!-- Sidebar user panel -->
<div class="user-panel">
  <div class="pull-left image">
    <img src="/img/master/users/avatar_{{ Auth::id() }}.jpg" class="img-circle" alt="User Image">
  </div>
  <div class="pull-left info">
    <p>Alexander Pierce</p>
    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
  </div>
</div>
<!-- search form -->
<form action="#" method="get" class="sidebar-form">
  <div class="input-group">
    <input type="text" name="q" class="form-control" placeholder="Search...">
    <span class="input-group-btn">
      <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
      </button>
    </span>
  </div>
</form>
<!-- /.search form -->
<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
  <li class="treeview">
    <a href="#">
      <i class="fa fa-address-book"></i> <span>Cadastros</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="/master/brindes"><i class="fa fa-gift"></i> Brindes</a></li>
      <li><a href="/master/cursos"><i class="fa fa-book"></i> Cursos</a></li>
      <li><a href="/master/departamentos"><i class="fa fa-users"></i> Departamentos</a></li>
      <li><a href="/master/instituicoes"><i class="fa fa-university"></i> Instituições</a></li>
      <li><a href="/master/tipos-agenda"><i class="fa fa-tag"></i> Tipos de Agenda</a></li>
      <li><a href="/master/tipos-contrato"><i class="fa fa-tag"></i> Tipos de Contrato</a></li>
      <li><a href="/master/tamanhos-beca"><i class="fa fa-graduation-cap"></i> Tamanho de Beca</a></li>
      <li><a href="/master/tamanhos-faixa"><i class="fa fa-graduation-cap"></i> Tamanho de Faixa</a></li>
      <li><a href="/master/tamanhos-foto"><i class="fa fa-photo"></i> Tamanho de Foto</a></li>
      <li><a href="/master/vendedores"><i class="fa fa-handshake-o "></i> Vendedores</a></li>
    </ul>
  </li>
  <li class="treeview">
    <a href="#">
      <i class="fa fa-legal"></i> <span>Contratos</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="/master/agenda"><i class="fa fa-calendar"></i> Agenda</a></li>
      <li class="treeview menu-open">
        <a href="#"><i class="fa fa-briefcase"></i> Contratos
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" style="display: block;">
          <li><a href="/master/contratos/create"><i class="fa fa-plus"></i> Novo</a></li>
          <li><a href="/master/contratos/"><i class="fa fa-list"></i> Lista</a></li>
          <li><a href="/master/identificacao"><i class="fa fa-user"></i> Identificação</a></li>
        </ul>
      </li>
      <li><a href="/master/participante"><i class="fa fa-graduation-cap"></i> Participantes</a></li>
    </ul>
  </li>
  <li class="treeview">
    <a href="#">
      <i class="fa fa-photo"></i> <span>Fotos</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="/master/fotos/upload"><i class="fa fa-upload"></i> Subir Fotos</a></li>
    </ul>
  </li>
</ul>
</section>
<!-- /.sidebar -->
</aside>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  @yield('content')
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
<div class="pull-right hidden-xs">
<b>Versão</b> Beta
</div>
<strong> {{ date('Y') }} <a href="http://f5sg.com.br" target="_blank">F5 Software de Gestão</a>.</strong>
</footer>
<!-- Add the sidebar's background. This div must be placed
immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
</body>
</html>
