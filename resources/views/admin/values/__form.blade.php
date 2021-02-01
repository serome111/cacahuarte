<div class="row">
	<div class="mb-3 col-sm-6">
	  <label for="title" class="form-label">titulo</label>
	  <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" placeholder="titulo" value="{{ old('title',$values->title) }}" onkeyup="titleValue();">
	  @error('title')
	  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
	  @enderror
	</div>
	<div class="mb-3 col-sm-6">@lang('Descripcion')</label>
	  <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="2" onkeyup="descriptionValue();" required>{{ old('description',$values->description) }}</textarea>
	   @error('description')
	  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
	  	@enderror
	</div>
	<div class="mb-3 mb-3 col-md-5">
	  <label for="picture" class="form-label">Subir imagen de fonto</label>
	  <input class="form-control @error('picture') is-invalid @enderror" type="file" picture="picture" name="picture" id="picture" value="{{ old('picture',$values->picture) }}" onchange="pictureValue();"
	  {{$action = empty($values->picture) ? 'required' : ''}}>
	  @error('picture')
	  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
	  	@enderror
	</div>
	<div class="mb-3 mb-3 col-md-5">
		<label for="state" class="form-label">Estado del banner</label>
		<select class="form-select @error('state') is-invalid @enderror"name="state" id="state">
		  <option value="" selected>Seleccione el estado</option>
		  <option value="1">Activo</option>
		  <option value="0">inactivo</option>
		</select>
		@error('state')
	  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
	  	@enderror
	</div>
	<div class="mb-3 mb-3 col-md-12 d-md-flex justify-content-md-end">
		<button  class="btn btn-primary" type="submit">{{ $btntxt }}</button>
	</div>

</div>
