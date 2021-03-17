 <!-- ======= Values Section ======= -->
<section id="values" class="values">
  <div class="container">
    <div class="row">
      @if($values->isEmpty())
        <div class="col-md-6 d-flex align-items-stretch" data-aos="fade-up">
              <div class="card" style="background-image: url(img/values-1.jpg);">
                <div class="card-body">
                  <h5 class="card-title"><a href="#">Nuestra mision</a></h5>
                  <p class="card-text">Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod tempor ut labore et dolore magna aliqua.</p>
                  <div class="read-more"><a href="#"><i class="icofont-arrow-right"></i> Read More</a></div>
                </div>
              </div>
        </div>

        <div class="col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="fade-up" data-aos-delay="100">
          <div class="card" style="background-image: url(img/values-2.jpg);">
            <div class="card-body">
              <h5 class="card-title"><a href="#">Nuestro plan</a></h5>
              <p class="card-text">Sed ut perspiciatis unde omnis iste natus error sit voluptatem doloremque laudantium, totam rem.</p>
              <div class="read-more"><a href="#"><i class="icofont-arrow-right"></i> Read More</a></div>
            </div>
          </div>
        </div>

        <div class="col-md-6 d-flex align-items-stretch mt-4" data-aos="fade-up" data-aos-delay="200">
          <div class="card" style="background-image: url(img/values-3.jpg);">
            <div class="card-body">
              <h5 class="card-title"><a href="#">Nuestra vision</a></h5>
              <p class="card-text">Nemo enim ipsam voluptatem quia voluptas sit aut odit aut fugit, sed quia magni dolores.</p>
              <div class="read-more"><a href="#"><i class="icofont-arrow-right"></i> Read More</a></div>
            </div>
          </div>
        </div>

        <div class="col-md-6 d-flex align-items-stretch mt-4" data-aos="fade-up" data-aos-delay="300">
          <div class="card" style="background-image: url(img/values-4.jpg);">
            <div class="card-body">
              <h5 class="card-title"><a href="#">nuestro cuidado</a></h5>
              <p class="card-text">Nostrum eum sed et autem dolorum perspiciatis. Magni porro quisquam laudantium voluptatem.</p>
              <div class="read-more"><a href="#"><i class="icofont-arrow-right"></i> Read More</a></div>
            </div>
          </div>
        </div>
      @else

        @for($c=0 ; $c < 4; $c++)
          @if($c <= 1)
            <div class="col-md-6 d-flex align-items-stretch {{$r = $c==0 ? '' : 'mt-4 mt-md-0' }} " data-aos="fade-up" {{$x = $c==0 ? '' : " data-aos-delay='100' "}}>
              <div class="card" style="background-image: url({{$values[$c]->picture}});">
                <div class="card-body">
                  <h5 class="card-title">
                    <a href="#">{{$values[$c]->title}}</a>
                  </h5>
                  <p class="card-text">{{$values[$c]->description}}</p>
                  <div class="read-more">
                    <a href="{{$values[$c]->link}}">
                      <i class="icofont-arrow-right"></i>Leer completo
                    </a>
                  </div>
                </div>
              </div>
            </div>
          @elseif($c > 1)
            @if(count($values) === 4)
              <div class="col-md-6 d-flex align-items-stretch mt-4" data-aos="fade-up" {{$y = $c==2 ? 'data-aos-delay="200"' : 'data-aos-delay="300"'}}>
                <div class="card" style="background-image: url({{$values[$c]->picture}});">
                  <div class="card-body">
                    <h5 class="card-title">
                      <a href="#">{{$values[$c]->title}}</a>
                    </h5>
                    <p class="card-text">{{$values[$c]->description}}</p>
                    <div class="read-more">
                      <a href="{{$values[$c]->link}}">
                        <i class="icofont-arrow-right"></i>Leer completo
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            @endif
          @endif
        @endfor
      @endif
    </div>
  </div>
</section>
<!-- End Values Section -->