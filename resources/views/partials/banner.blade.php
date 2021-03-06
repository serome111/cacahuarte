<!-- ======= Hero Section ======= -->
 @if($banners->isEmpty())
  <section id="hero" class="d-flex flex-column justify-content-center align-items-center">
  <div class="container" data-aos="fade-in">
    <h1>Bienvenido a Cacahuarte</h1>
    <h2>Somos una empresa productora de cacao 100% natural del municipio de elias Huila Colombia</h2>
    <div class="d-flex align-items-center">
      <i class="bx bxs-right-arrow-alt get-started-icon"></i>
      <a href="#about" class="btn-get-started scrollto">Conocenos</a>
    </div>
  </div>
  </section>
 @else
  @foreach($banners as $banner)
    <section id="hero" class="d-flex flex-column justify-content-center align-items-center" style="background: url({{ $banner->photo }})">
      <div class="container" data-aos="fade-in">
        <h1>{{ $banner->title }}</h1>
        <h2>{{ $banner->description }}</h2>
        <div class="d-flex align-items-center">
          <i class="bx bxs-right-arrow-alt get-started-icon"></i>
          <a href="#about" class="btn-get-started scrollto">Conocenos</a>
        </div>
      </div>
    </section>
  @endforeach
@endif
 <!-- End Hero -->