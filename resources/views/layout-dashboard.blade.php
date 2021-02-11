<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','titulo')</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">
  <!-- Favicons -->
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Vendor CSS Files -->
  <link rel="stylesheet" type="text/css" href="{{ mix('css/css/bootstrap2.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ mix('css/dashboard.css')}}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" type="text/css" href="{{ mix('css/bootstrap.min.css')}}">
  <link href="{{ mix('css/icofont.min.css')}}" rel="stylesheet">
  <link href="{{ mix('css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{ mix('css/venobox.css')}}" rel="stylesheet">
  <link href="{{ mix('css/owl.carousel.min.css')}}" rel="stylesheet">
  <link href="{{ mix('css/aos.css')}}" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="{{ mix('css/style.css')}}" rel="stylesheet">
</head>

<body>
  <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Cacahuarte</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">salir</a>
    </li>
  </ul>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
  @include('partials.session-status')
</header>
<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{route('index') }}">
              <span data-feather="home"></span>
              Ir al Sitio principal
            </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#MenuPage" role="button" aria-expanded="false" aria-controls="MenuPage">
                <span data-feather="settings"></span>Pagina Principal
              </a>
            <div class="collapse px-3" id="MenuPage">
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('banner.index') }}">
                  <span data-feather="image"></span>
                    Banner principal
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('why-about-us.index') }}">
                    <span data-feather="edit"></span>
                    ¿por qué nosotros?
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('clients.index') }}">
                    <span data-feather="users"></span>
                    Nuestros Clientes
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('about_us.index') }}">
                    <span data-feather="users"></span>
                    Acerca de nosotros
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('values.index') }}">
                    <span data-feather="bar-chart-2"></span>
                    Imagen empresarial
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('team.index') }}">
                    <span data-feather="users"></span>
                    Equipo de trabajo
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('faq.index') }}">
                    <span data-feather="help-circle"></span>
                    Preguntas Frecuentes
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#Menuproduc" role="button" aria-expanded="false" aria-controls="Menuproduc">
              <span data-feather="shopping-cart"></span>Productos
            </a>
            <div class="collapse px-3" id="Menuproduc">
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('products.index') }}">
                  <span data-feather="shopping-bag"></span>
                    Inventario
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('categories.index') }}">
                  <span data-feather="grid"></span>
                    Categorias
                  </a>
                </li>
              </ul>
            </div>
          </li>
        </ul>
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Saved reports</span>
          <a class="link-secondary" href="#" aria-label="Add a new report">
            <span data-feather="plus-circle"></span>
          </a>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Current month
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Last quarter
            </a>
          </li>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</div>
  @yield('content')

<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
</body>
<!--JS Files-->
  <script type="text/javascript" src="{{ mix('js/bootstrap.bundle.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
  <script type="text/javascript" src="{{ mix('js/dashboard.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/clients.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/team.js') }}"></script>
</html>