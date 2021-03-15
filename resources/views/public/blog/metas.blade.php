@extends('layout')
@section('title','Cacahuarte | Metas')
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
                <img src="/img/logo5.png" alt="" class="img-fluid">
              </div>

              <h2 class="entry-title">
                <a href="blog-single.html">Metas</a>
              </h2>


              <div class="entry-content">
                <ul>
                  <li>
                    Crecer en ventas respecto al año 2018.
                  </li>
                  <li>
                    Mejorar la calidad de vida e ingreso de los cultivadores de cacao regional, con sus buenas prácticas agrícolas.
                  </li>
                  <li>
                    Generar empleo en la región (Fábrica de Trasformación de Cacao).
                  </li>
                  <li>
                    Posicionamiento de producto regional (chocolate de mesa) a nivel nacional e internacional.
                  </li>
                </ul>
              </div>


            </article><!-- End blog entry -->


          </div><!-- End blog entries list -->

          @include('public/blog/partials/sidebar')

        </div>

      </div>
    </section>
    <!-- End Blog Section -->

@endsection()