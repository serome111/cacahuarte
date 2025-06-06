<!-- ======= F.A.Q Section ======= -->
<section id="faq" class="faq section-bg">
  <div class="container">

    <div class="section-title">
      <h2 data-aos="fade-up">F.A.Q</h2>
      <p data-aos="fade-up">Aqui podras encontrar las preguntas mas frecuentes de nuestros productos.</p>
    </div>
    <div class="faq-list">
    <ul>
    @for($i = 0; $i < count($faqs); $i++)
        <li data-aos="fade-up" data-aos-delay="{{ $i }}00">
            <i class="bx bx-help-circle icon-help"></i>
            <a data-bs-toggle="collapse" href="#" class="collapse" data-bs-target="#faq-list-{{ $i }}">
                {{ $faqs[$i]->question }}
                <i class="bx bx-chevron-down icon-show"></i>
            </a>
            <div id="faq-list-{{ $i }}" class="collapse" data-bs-parent=".faq-list">
                <p>{{ $faqs[$i]->solution }}</p>
                @if($faqs[$i]->link)
                    <a href="{{ $faqs[$i]->link }}" class="details-link" title="Más detalles" target="_blank" rel="noopener">
                        <i class="bx bx-link"></i> {{ $faqs[$i]->textLink }}
                    </a>
                @endif
            </div>
        </li>
    @endfor
</ul>

    </div>
  </div>
</section><!-- End F.A.Q Section -->