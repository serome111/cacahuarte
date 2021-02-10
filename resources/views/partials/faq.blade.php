<!-- ======= F.A.Q Section ======= -->
<section id="faq" class="faq section-bg">
  <div class="container">

    <div class="section-title">
      <h2 data-aos="fade-up">F.A.Q</h2>
      <p data-aos="fade-up">Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
    </div>
    <div class="faq-list">
      <ul>
        @for($i=0; $i < count($faqs); $i++)
            <li data-aos="fade-up" data-aos-delay="{{$i}}00">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse" data-bs-target="#faq-list-{{$i}}">{{ $faqs[$i]->question}} <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-{{$i}}" class="collapse" data-bs-parent=".faq-list">
                <p>
                  {{ $faqs[$i]->solution }}
                  <a href="{{ $faqs[$i]->link }}" class="details-link" title="Mas detalles"><i class="bx bx-link">{{ $faqs[$i]->textLink }}</i></a>
                </p>
              </div>
            </li>
        @endfor
      </ul>
    </div>

  </div>
</section><!-- End F.A.Q Section -->