<div class="row g-4">
	<div class="col-sm-3">
	  <label for="code" class="form-label">Codigo del producto</label>
	  <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code" placeholder="Codigo" value="{{ old('code',$products->code) }}">
	  @error('code')
	  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
	  @enderror
	</div>

	<div class="col-sm-3">
	  <label for="name" class="form-label">Nombre del producto</label>
	  <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Nombre" value="{{ old('name',$products->name) }}">
	  @error('name')
	  	<span class="invalid-feedback" role="alert">
	  		<strong>{{$message}}</strong>
	  	</span>
	  @enderror
	</div>

	<div class="col-sm-3">
	  <label for="price" class="form-label">Precio del producto</label>
	  <input type="text" class="form-control @error('price') is-invalid @enderror" name="price" id="price" placeholder="Precio" value="{{ old('price',$products->price) }}">
	  @error('price')
	  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
	  @enderror
	</div>

	<div class="col-sm-3">
	  <label for="stock" class="form-label">Cantidad en inventario</label>
	  <input type="text" class="form-control @error('stock') is-invalid @enderror" name="stock" id="stock" placeholder="Cantidad" value="{{ old('stock',$products->stock) }}">
	  @error('stock')
	  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
	  @enderror
	</div>

	<div class="col-sm-3">
		<label for="categorie" class="form-label">Categoria del producto</label>
		<select class="form-select @error('categorie_id') is-invalid @enderror" name="categorie_id" id="categorie">
		  <option value="" selected>Seleccione la categoria</option>
			@if($categories->count() === 0)
			  <option value="">No existen categorias creadas</option>
			@else
				@foreach($categories as $categorie)
					@if(old('categorie_id',$products->categorie_id) == $categorie->id)
			  			<option value="{{$categorie->id}}" selected>{{$categorie->name}}</option>
			  		@endif
			  		<option value="{{$categorie->id}}">{{$categorie->name}}</option>
			  	@endforeach
		  	@endif
		</select>
		@error('categorie_id')
	  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
	  	@enderror
	</div>

	<div class="col-sm-3">
		<label for="state" class="form-label">Estado del producto</label>
		<select class="form-select @error('state') is-invalid @enderror"name="state" id="state">
			<option value="" selected>Seleccione el estado</option>
			@if(old('state',$products->state) === 1)
				<option value="1" selected>Activo</option>
				<option value="0">inactivo</option>
			@elseif(old('state',$products->state) === 0)
				<option value="0" selected>inactivo</option>
				<option value="1">Activo</option>
			@endif
			@if(empty($products->state))
				<option value="1">Activo</option>
				<option value="0">inactivo</option>
			@endif
		</select>
		@error('state')
	  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
	  	@enderror
	</div>

	<div class="col-sm-5">
		<label for="picture" class="form-label">
	  		Subir imagen de producto
		</label>
	  	<input class="form-control @error('picture') is-invalid @enderror" type="file" picture="picture" name="picture" id="picture" value="{{ old('picture',$products->picture) }}" onchange="pictureProduct();" {{$req = empty($products->picture) ? 'required' : ''}}>
		@error('picture')
			<span class="invalid-feedback" role="alert">
		  		<strong>{{$message}}</strong>
		  	</span>
		@enderror
	</div>

	<div class="col-sm-7">@lang('Descripcion del producto')</label>
	  <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="2">{{ old('description',$products->description) }}</textarea>
	   @error('description')
	  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
	  	@enderror
	</div>


	<div class="col-sm-3">
			<div class="card position-relative">
				<img src="{{ $action = empty($products->picture) ? '/img/portfolio/caja.png' : $products->picture }}" id="producImg" class="card-img-top" alt="producto">
			</div>
	</div>

	<div class="mb-3 mb-3 col-md-12 d-md-flex justify-content-md-end">
		<button  class="btn btn-primary" type="submit">{{ $btntxt }}</button>
	</div>
</div>

<script type="text/javascript">

	function pictureProduct(){
		const $seleccionArchivos = document.querySelector("#picture");
		const archivos = $seleccionArchivos.files;
		const primerArchivo = archivos[0];
		const objectURL = URL.createObjectURL(primerArchivo);
		document.getElementById("producImg").src = objectURL;
	//doc
	//https://parzibyte.me/blog/2019/05/20/previsualizar-imagen-input-file-javascript-html/
	}
</script>
