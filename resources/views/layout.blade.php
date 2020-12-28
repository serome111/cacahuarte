<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>@yield('title','titulo')</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link rel="stylesheet" type="text/css" href="{{ mix('css/bootstrap.min.css')}}">
  <link href="{{ mix('css/icofont.min.css')}}" rel="stylesheet">
  <link href="{{ mix('css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{ mix('css/venobox.css')}}" rel="stylesheet">
  <link href="{{ mix('css/owl.carousel.min.css')}}" rel="stylesheet">
  <link href="{{ mix('css/aos.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ mix('css/style.css')}}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Flexor - v3.0.0
  * Template URL: https://bootstrapmade.com/flexor-free-multipurpose-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
  @include('partials/header')

<main id="main">
  @yield('content')
</main>




@include('partials/footer')
<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
</body>
<!--JS Files-->
  <script type="text/javascript" src="{{ mix('js/js.js') }}"></script>
</html>