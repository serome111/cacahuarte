<!-- ======= Why Us Section ======= -->
    <section id="why-us" class="why-us">
      <div class="container">
        <div class="row">
          @foreach($tarjetas as $tarjeta)
          @if($tarjeta->state == 1)
          <div class="col-xl-4 col-lg-5" data-aos="fade-up">
            <div class="content">
              <h3> {{ $tarjeta->title }} </h3>
              <p> {{ $tarjeta->description }} </p>
              <div class="text-center">
                <a href="#" class="more-btn">¿Quieres enterarte de más? <i class="bx bx-chevron-right"></i></a>
              </div>
            </div>
          </div>
          @endif
          @endforeach
          <div class="col-xl-8 col-lg-7 d-flex">
            <div class="icon-boxes d-flex flex-column justify-content-center">
              <div class="row">
              @foreach($tarjetas as $card)
                @if($card->state == 2 )
                <div class="col-xl-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                  <div class="icon-box mt-4 mt-xl-0">
                    <i class="{{ $card->icon_class }}"></i>
                    <h4> {{ $card->title }} </h4>
                    <p> {{ $card->description }} </p>
                  </div>
                </div>
                @endif
              @endforeach
              </div>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End Why Us Section -->