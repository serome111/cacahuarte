<!-- ======= Top Bar ======= -->
  <section id="topbar" class="d-none d-lg-block">
    <div class="container d-flex justify-content-between">
      <div class="contact-info">
        <ul>
          <li><i class="icofont-envelope"></i><a href="mailto:cacahuarte@gmail.com">cacahuarte@gmail.com</a></li>
          <li><i class="icofont-phone"></i> +57 320 863 7017</li>
          <li><i class="icofont-clock-time icofont-flip-horizontal"></i> Lunes-Viernes 9am - 5pm</li>
        </ul>

      </div>
      <div class="cta">
        <a href="#about" class="scrollto">Conocenos</a>
        <!--Get Started-->
        @if (Auth::guest())
        @else
          @if(auth()->user()->role->name === "admin")
            <a href="/base" class="scrollto">Administrar</a>
          @endif
        @endif
      </div>
    </div>
  </section>





  <!-- ======= Header ======= -->
  <header id="header">
    <div class="container d-flex justify-content-between">

      <div class="logo">
        <h1 class="text-light"><a href="/"><span>CACAHUARTE</span></a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li class="active"><a href="/">Inicio</a></li>
          <li><a href="/#about">Nosotros</a></li>
          <li><a href="/#portfolio">Portfolio</a></li>
          <li><a href="/#team">Equipo</a></li>
          {{-- <li><a href="blog.html">Blog</a></li> --}}
          <li><a href="#contact">Contactanos</a></li>

        </ul>
      </nav><!-- .nav-menu -->

    </div>
  </header><!-- End Header -->