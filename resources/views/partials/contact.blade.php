 <!-- ======= Contact Section ======= -->
<section id="contact" class="contact">
  <div class="container">

    <div class="section-title">
      <h2 data-aos="fade-up">Contáctanos</h2>
      <p data-aos="fade-up">Aquí podras dejarnos un mensaje, inquietud, sugerencia o el mensaje que nos quieras enlistar.</p>
    </div>

    <div class="row justify-content-center">

      <div class="col-xl-3 col-lg-4 mt-4" data-aos="fade-up">
        <div class="info-box">
          <i class="bx bx-map"></i>
          <h3>Nuestra dirección</h3>
          <p>Vereda Laguneta Finca Piedras Gordas Elias Huila.</p>
        </div>
      </div>

      <div class="col-xl-3 col-lg-4 mt-4" data-aos="fade-up" data-aos-delay="100">
        <div class="info-box">
          <i class="bx bx-envelope"></i>
          <h3>Escríbenos</h3>
          <p>cacahuarte@gmail.com</p>
        </div>
      </div>
      <div class="col-xl-3 col-lg-4 mt-4" data-aos="fade-up" data-aos-delay="200">
        <div class="info-box">
          <i class="bx bx-phone-call"></i>
          <h3>Llámanos</h3>
          <p>+57 {{$global_phone}}<br>+57 {{$global_phone2}}</p>
        </div>
      </div>
    </div>

    <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="300">
      <div class="col-xl-9 col-lg-12 mt-4">
        <form action="{{ route('contact_us.index') }}" method="POST" role="form" class="php-email-form">
          @csrf
          <div class="row">
            <div class="col-md-6 form-group">
              <input type="text" name="name" class="form-control" id="name" placeholder="Tu Nombre" data-rule="minlen:4" data-msg="El nombre es requerido con mínimo 4 letras" />
              <div class="validate"></div>
            </div>
            <div class="col-md-6 form-group mt-3 mt-md-0">
              <input type="email" class="form-control" name="email" id="email" placeholder="Tu Email" data-rule="email" data-msg="Ingresa un email válido" />
              <div class="validate"></div>
            </div>
          </div>
          <div class="form-group mt-3">
            <input type="text" class="form-control" name="subject" id="subject" placeholder="Asunto" data-rule="minlen:4" data-msg="El asunto es requerido con mínimo 4 letras" />
            <div class="validate"></div>
          </div>
          <div class="form-group mt-3">
            <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Por favor escribe algo para nosotros" placeholder="Mensaje"></textarea>
            <div class="validate"></div>
          </div>
          <div class="mb-3">
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Tu mensaje ha sido enviado con éxito. ¡Gracias por escribirnos!</div>
          </div>
          <div class="text-center"><button type="submit">Enviar Mensaje</button></div>
        </form>
      </div>

    </div>

  </div>
</section><!-- End Contact Section -->