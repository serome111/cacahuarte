@extends('layout')
@section('title','Cacahuarte | Objetivos Empresariales')
@section('content')

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
      	<!-- hola revisores de codigo -->
      </div>
    </section>
    <!-- End Breadcrumbs -->

    <!-- ======= Blog Section ======= -->
    <section id="blog" class="blog">
      <div class="container">

        <div class="row">

          <div class="col-lg-8 entries">

            <article class="entry entry-single">

              <div class="entry-img">
                <img src="/img/objetives1.png" alt="" class="img-fluid">
              </div>

              <h2 class="entry-title">
                <a href="blog-single.html">Objetivos Empresariales</a>
              </h2>


              <div class="entry-content">
                <p>
                  <ul>
                    <li>
                      Fabricar un producto que se caracterice por su proceso natural y artesanal, teniendo en cuenta un índice de fermentación adecuado; para su procesamiento.
                    </li>
                    <li>
                      Propender por el crecimiento económico y empresarial de la región.
                    </li>
                    <li>
                      Articular el trabajo en equipo para todo el proceso desde la siembra hasta la
                      comercialización del producto trasformado.
                    </li>
                    <li>
                      Posicionar el Cacao Puro N&M a nivel nacional e internacional.
                    </li>
                  </ul>
                </p>


               {{--  <blockquote>
                  <i class="icofont-quote-left quote-left"></i>
                  <p>
                    El cacao es el futuro del corazon lorem
                  </p>
                  <i class="las la-quote-right quote-right"></i>
                  <i class="icofont-quote-right quote-right"></i>
                </blockquote> --}}
              </div>



            </article><!-- End blog entry -->


          </div><!-- End blog entries list -->

          @include('public/blog/partials/sidebar')

        </div>

      </div>
    </section>
    <!-- End Blog Section -->

@endsection()