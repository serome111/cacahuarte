@extends('layout')
@section('title','Cacahuarte | Valores')
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
                <a href="blog-single.html">Valores</a>
              </h2>


              <div class="entry-content">
                <ul>
                  <li>
                    Pro – actividad
                  </li>
                  <li>
                    Trabajo en equipo.
                  </li>
                  <li>
                    Responsabilidad
                  </li>
                  <li>
                    Calidad
                  </li>
                  <li>
                    Compromiso
                  </li>
                  <li>
                    Innovación y servicio
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