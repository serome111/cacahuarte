@extends('layout')
@section('title','Cacahuarte | visión')
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
                <img src="/img/todo2.svg" alt="" class="img-fluid">
              </div>

              <h2 class="entry-title">
                <a href="blog-single.html">Visión</a>
              </h2>


              <div class="entry-content">
                <p>
                  Ser líderes en la formación del sector cacao cultor, con el fin de estandarizar y establecer como costumbres las buenas prácticas agrícolas, logrando materia prima de excelente calidad que será trasformada y comercializada, con el fin de satisfacer las necesidades nutricionales de los habitantes de la región. Constituirnos como una empresa sustentable y generadora de empleo para las familias del municipio de Elías - Huila.
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