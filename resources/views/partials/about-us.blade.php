
 <!-- ======= About Section ======= -->
<section id="about" class="about section-bg">
  <div class="container">
    @foreach($about_us as $about)
    <div class="row">
      <div class="col-xl-5 col-lg-6 video-box d-flex justify-content-center align-items-stretch position-relative" data-aos="fade-right">
        <a href="https://youtu.be/3fdRKJkADlc" class="venobox play-btn mb-4" data-vbtype="video" data-autoplay="true" alt="Video sobre nosotros"></a>
      </div>
      <div class="col-xl-7 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
        <h4 data-aos="fade-up">Sobre nosotros</h4>
        <h3 data-aos="fade-up">{{$about->title}}</h3>
        <p data-aos="fade-up">{{$about->description}}</p>

        <div class="icon-box" data-aos="fade-up">
          <div class="icon"><i class="{{$about->icon1}}"></i></div>
          <h4 class="title"><a href="#">{{$about->title1}}</a></h4>
          <p class="description">V{{$about->description1}}</p>
        </div>

        <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
          <div class="icon"><i class="{{$about->icon2}}"></i></div>
          <h4 class="title"><a href="#">{{$about->title2}}</a></h4>
          <p class="description">{{$about->description2}}</p>
        </div>

        <div class="icon-box" data-aos="fade-up" data-aos-delay="200">
          <div class="icon"><i class="{{$about->icon3}}"></i></div>
          <h4 class="title"><a href="#">{{$about->title3}}</a></h4>
          <p class="description">{{$about->description}}</p>
        </div>

      </div>
    </div>
    @endforeach
  </div>
</section><!-- End About Section -->