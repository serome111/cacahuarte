<div class="row">
	<div class="mb-3 col-sm-6">
	  <label for="question" class="form-label">Pregunta Frecuente</label>
	  <input type="text" class="form-control @error('question') is-invalid @enderror" name="question" id="question" placeholder="titulo" value="{{ old('question',$faq->question) }}">
	  @error('question')
	  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
	  @enderror
	</div>
	<div class="mb-3 col-sm-6">@lang('Descripcion o solucion')</label>
	  <textarea class="form-control @error('solution') is-invalid @enderror" name="solution" id="solution" rows="2" required>{{ old('solution',$faq->solution) }}</textarea>
	   @error('solution')
	  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
	  	@enderror
	</div>
	<div class="mb-3 col-sm-6">
	  <label for="link" class="form-label">Enlace</label>
	  <input type="text" class="form-control @error('link') is-invalid @enderror" name="link" id="link" placeholder="titulo" value="{{ old('link',$faq->link) }}">
	  @error('link')
	  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
	  @enderror
	</div>
	<div class="mb-3 col-sm-6">
	  <label for="textLink" class="form-label">Texto del enlace</label>
	  <input type="text" class="form-control @error('textLink') is-invalid @enderror" name="textLink" id="textLink" placeholder="titulo" value="{{ old('textLink',$faq->textLink) }}">
	  @error('textLink')
	  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
	  @enderror
	</div>
	<div class="mb-3 mb-3 col-md-12 d-md-flex justify-content-md-end">
		<button  class="btn btn-primary" type="submit">{{ $btntxt }}</button>
	</div>
</div>