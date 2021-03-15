@extends('layout')
@section('title','Cacahuarte | Misión')
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
                <a href="blog-single.html">Misión</a>
              </h2>


              <div class="entry-content">
                <p>
                  En el año 2040, Cacahuarte estará posicionada a nivel regional, como empresa líder, innovadora y generadora de desarrollo social.
                </p>
              </div>


            </article><!-- End blog entry -->


          </div><!-- End blog entries list -->

          @include('public/blog/partials/sidebar')

        </div>

      </div>
    </section>
    <!-- End Blog Section -->

@endsection()