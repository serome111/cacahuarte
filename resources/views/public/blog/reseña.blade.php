@extends('layout')
@section('title','Cacahuarte | Reseña Historica')
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
                <img src="/img/cacahuartenm.jpg" alt="" class="img-fluid">
              </div>

              <h2 class="entry-title">
                <a href="blog-single.html">Reseña Historica</a>
              </h2>


              <div class="entry-content">
                <p style="text-align: justify;">
                  El municipio de Elías del departamento del Huila siempre se ha caracterizado por ser agrícola, con una cultura diversa en el uso de los recursos naturales. El cacao ha sido uno de los productos tradicionales. Esta condición tiene raíces que se fundamentan en la idiosincrasia de sus habitantes; de esta manera, han existido factores económicos y culturales que generalizaron la costumbre de vender la producción en grano a empresas que aseguran su compra, y por otra parte la ausencia de opciones
                   diferentes comercialización.

                </p>

                <p style="text-align: justify;">
                  En general, en la zona no se ha logrado establecer la visión de transformar la producción agrícola con el fin de generar valor agregado.
                </p>
                <img src="/img/campo1.png" class="img-fluid center-block" alt="">
                <p></p>
                <p style="text-align: justify;">
                  Por tal motivo en el año 2015 se creó por iniciativa de dos mujeres emprendedoras y el apoyo del programa SENA Emprende Rural conformar la iniciativa de una microempresa particular dedicada a la transformación de cacao, denominada CACAHUARTE, en donde se elabora chocolate de mesa, cuyo mercado principal es con los habitantes del municipio de Elías y algunos municipios cercanos del sur del Huila, como Pitalito, Oporapa, Saladoblanco entre otros.
                </p>
                <img src="/img/produccion.png" class="img-fluid" style="text-align: right " alt="">
                <p></p>
                <p style="text-align: justify;">
                  Estas dos mujeres emprendedoras quienes son madre e hija, en la necesidad de ver crecer su empresa y generar empleo a los habitantes del sector ampliaron su grupo empresarial vinculando sus 8 hermanos, así continuaron con la transformación del cacao y la comercialización al interior de algunos departamentos del Colombia.
                  Ante la situación descrita, este proyecto propende por el rescate y fortalecimiento de la transformación de cacao en el municipio de Elías en aras de generar valor agregado en la producción cacaotera que redunde en el mejoramiento de la calidad de vida de los cacao-cultores y la generacion de empleos directo en la cabecera municipal de Elías a fin decontribuir con la disminución del índice de desempleo de la zona.
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