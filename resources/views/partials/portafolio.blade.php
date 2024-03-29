<!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio">
      <div class="container">
        <div class="section-title">
          <h2 data-aos="fade-up">Portafolio</h2>
          <p data-aos="fade-up">Estos son todos los productos que hemos producido con nuestro emprendimiento que ya mismo puedes pedir y para disfrutar en tu hogar</p>
        </div>

        <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">

          @if(count($products))
            @foreach($products as $product)
              <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                <img src="{{$product->picture}}" class="img-fluid" alt="{{$product->name}}">
                <div class="portfolio-info">
                  <h4>{{$product->name}}</h4>
                  <p>{{$product->price}}</p>
                  <a href="{{$product->picture}}" data-gall="portfolioGallery" class="venobox preview-link" title="{{$product->name}}"><i class="bx bx-plus"></i></a>
                  <a loading="lazy" href="{{ route('detail',$product->id) }}" class="details-link" title="Mas detalles"><i class="bx bx-link"></i></a>
                </div>
              </div>
            @endforeach
          @else
           <div class="col-lg-4 col-md-6 portfolio-item filter-card">
              <img loading="lazy" src="img/portfolio/cacahuarte.png" class="img-fluid" alt="cacahuarte">
              <div class="portfolio-info">
                <h4>Card 1</h4>
                <p>Card</p>
                <a loading="lazy" href="img/portfolio/cacahuarte.png" data-gall="portfolioGallery" class="venobox preview-link" title="Card 1"><i class="bx bx-plus"></i></a>
                <a href="{{ route('detail',1) }}" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>
          @endif
        </div>

      </div>
    </section><!-- End Portfolio Section -->