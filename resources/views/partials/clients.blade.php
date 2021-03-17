<!-- ======= Clients Section ======= -->
<section id="clients" class="clients">
  <div class="container" data-aos="fade-up">

    <div class="owl-carousel clients-carousel">
      @forelse($clientes as $cliente)
        @if($cliente->estado == 1)
          <img src="{{ url('images/clients/'.$cliente->imagen) }}" alt="">
        @endif
        @empty
          <img loading="lazy" src="img/clients/client-1.png" alt="#">
          <img loading="lazy" src="img/clients/client-2.png" alt="#">
          <img loading="lazy" src="img/clients/client-3.png" alt="#">
          <img loading="lazy" src="img/clients/client-4.png" alt="#">
          <img loading="lazy" src="img/clients/client-5.png" alt="#">
          <img loading="lazy" src="img/clients/client-6.png" alt="#">
          <img loading="lazy" src="img/clients/client-7.png" alt="#">
          <img loading="lazy" src="img/clients/client-8.png" alt="#">
        @endforelse
    </div>

  </div>
</section><!-- End Clients Section -->