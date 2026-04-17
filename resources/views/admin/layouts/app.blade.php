<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title>NewaChen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/css/adminlte.min.css"/>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('admin/css/custom.css') }}">
    <style>
      /* Keep Dashboard menu always open and prevent toggle */
      .sidebar-menu > .nav-item.menu-open {
        pointer-events: auto;
      }
      
      .sidebar-menu > .nav-item.menu-open > .nav-treeview {
        display: block !important;
        max-height: none !important;
        overflow: visible !important;
      }
    </style>
  </head>

  <body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <div class="app-wrapper">

      <!-- ══ ADMINLTE HEADER — UNTOUCHED ══ -->
      <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"><i class="bi bi-list"></i></a>
            </li>
            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Home</a></li>
           <!-- <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Contact</a></li>-->
          </ul>
          <ul class="navbar-nav ms-auto">
           <!-- <li class="nav-item">
              <a class="nav-link" href="#" role="button"><i class="bi bi-search"></i></a>
            </li>
           <li class="nav-item dropdown">
              <a class="nav-link" data-bs-toggle="dropdown" href="#">
                <i class="bi bi-chat-text"></i><span class="navbar-badge badge text-bg-danger">3</span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <a href="#" class="dropdown-item">
                  <div class="d-flex"><div class="flex-grow-1">
                    <h3 class="dropdown-item-title">Brad Diesel <span class="float-end fs-7 text-danger"><i class="bi bi-star-fill"></i></span></h3>
                    <p class="fs-7">Call me whenever you can...</p>
                    <p class="fs-7 text-secondary"><i class="bi bi-clock-fill me-1"></i> 4 Hours Ago</p>
                  </div></div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link" data-bs-toggle="dropdown" href="#">
                <i class="bi bi-bell-fill"></i><span class="navbar-badge badge text-bg-warning">15</span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item"><i class="bi bi-envelope me-2"></i>4 new messages<span class="float-end text-secondary fs-7">3 mins</span></a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
              </div>
            </li>-->
            <li class="nav-item">
              <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display:none"></i>
              </a>
            </li>
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img src="https://placehold.co/160x160/007bff/white?text=A" class="user-image rounded-circle shadow" alt="User"/>
                <span class="d-none d-md-inline">Admin</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <li class="user-header text-bg-primary">
                  <img src="https://placehold.co/160x160/007bff/white?text=A" class="rounded-circle shadow" alt=""/>
                  <p>Admin</p>
                </li>
                <li class="user-footer">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                    <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat float-end">
                        Sign out
                    </a>                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>

    
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <div class="sidebar-brand">
          <a href="#" class="brand-link">
            <img src="{{asset('web\images\logooo.svg')}}" alt="NewaChen Logo" class="brand-image opacity-100 " style="width:60px; max-height: 60px;"/>
            <img src="{{asset('web\images\logonameeee.png')}}" alt="NewaChen " class="brand-image opacity-100 " style="width:140px; max-height: 60px;"/>
            
          </a>
        </div>
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" data-accordion="false">
              <li class="nav-item menu-open">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-speedometer"></i>
                  <p>Dashboard<i class="nav-arrow bi bi-chevron-right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="nav-icon bi bi-circle"></i><p>Bookings</p></a></li>
                <!--  <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Dashboard v2</p></a></li>
                  <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Dashboard v3</p></a></li>-->
                </ul>
                  <ul class="nav nav-treeview">
                  <li class="nav-item"><a href="{{ route('admin.datewisebookings') }}" class="nav-link {{ request()->routeIs('admin.datewisebookings') ? 'active' : '' }}"><i class="nav-icon bi bi-file-earmark-bar-graph"></i><p>Reports</p></a></li>
                <!--  <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Dashboard v2</p></a></li>
                  <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Dashboard v3</p></a></li>-->
                </ul>
              </li>
              <!-- <li class="nav-item">
                <a href="{{ route('admin.datewisebookings') }}" class="nav-link {{ request()->routeIs('admin.datewisebookings') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-file-earmark-bar-graph"></i>
                  <p>Reports</p>
                </a>
              </li> -->
             <!-- <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon bi bi-palette"></i><p>Theme Generate</p></a></li>
              <li class="nav-item">
                <a href="#" class="nav-link"><i class="nav-icon bi bi-box-seam-fill"></i><p>Widgets<i class="nav-arrow bi bi-chevron-right"></i></p></a>
                <ul class="nav nav-treeview">
                  <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Small Box</p></a></li>
                  <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Info Box</p></a></li>
                  <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Cards</p></a></li>
                </ul>
              </li>
              <li class="nav-header">EXAMPLES</li>
              <li class="nav-item">
                <a href="#" class="nav-link"><i class="nav-icon bi bi-box-arrow-in-right"></i><p>Auth<i class="nav-arrow bi bi-chevron-right"></i></p></a>
                <ul class="nav nav-treeview">
                  <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Login</p></a></li>
                  <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Register</p></a></li>
                </ul>
              </li>
              <li class="nav-header">LABELS</li>
              <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon bi bi-circle text-danger"></i><p>Important</p></a></li>
              <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon bi bi-circle text-warning"></i><p>Warning</p></a></li>
              <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon bi bi-circle text-info"></i><p>Informational</p></a></li>-->
            </ul>
          </nav>
        </div>
      </aside>



    <main class="app-main">
        <div class="app-content">
            @yield('content')
        </div>
    </main>

    <footer class="app-footer">...</footer>

</div>
      
      <footer class="app-footer">
        <div class="float-end d-none d-sm-inline"></div>
        <strong><a href="" class="text-decoration-none"></a>Newachen</strong>
    
      </footer>

    </div>

    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
      <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/js/adminlte.min.js"></script>
 
  

  </body>
</html>
