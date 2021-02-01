<div class="row">
	<div class="mb-3 col-sm-6">
	  <label for="title" class="form-label">Nombre del Almacén</label>
	  <input type="text" class="form-control @error('nombreAlmacen') is-invalid @enderror" name="nombreAlmacen" placeholder="Nombre del Almacén" value="{{ old('nombreAlmacen',$cliente->nombreAlmacen) }}" required>
	  @error('nombreAlmacen')
	  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
	  @enderror
	</div>
<!-- nombre del representante -->
	<div class="mb-3 col-sm-6">
	  <label>Nombre del representante</label>
	  <input type="text" class="form-control @error('nombreRepresentante') is-invalid @enderror" name="nombreRepresentante" placeholder="Nombre del Representante" value="{{ old('nombreRepresentante',$cliente->nombreRepresentante) }}" required>
	   @error('nombreRepresentante')
	  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
	  	@enderror
	</div>
<!-- correo del cliente -->
	<div class="mb-3 col-sm-6">
	  <label>Correo Electrónico</label>
	  <input type="email" class="form-control @error('correo') is-invalid @enderror" name="correo" id="correo" placeholder="example@email.com" value="{{ old('correo',$cliente->correo) }}" required>
	   @error('correo')
	  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
	  	@enderror
	</div>
<!-- Teléfono del cliente -->
	<div class="mb-3 col-sm-6">
	  <label>Teléfono</label>
	  <input type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" placeholder="321*******" value="{{ old('telefono',$cliente->telefono) }}" maxlength="10" required>
	   @error('telefono')
	  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
	  	@enderror
	</div>
<!-- Departamentos  -->
	<div class="mb-3 mb-3 col-md-5">
		<label for="state" class="form-label">Departamento</label>
		<select class="form-select @error('departamento') is-invalid @enderror" name="departamento" id="departamento" onchange="capital();">
			@if(empty($cliente))
		  		<option value="" selected>Seleccione el departamento</option>
		  	@else
		  		<option value="{{$cliente->departamento}}">{{ $cliente->departamento }}</option>
		  	@endif
		</select>
		@error('departamento')
	  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
	  	@enderror
	</div>
<!-- ciudades  -->
	<div class="mb-3 mb-3 col-md-5">
		<label for="state" class="form-label">Ciudad/Municipio</label>
		<select class="form-select @error('state') is-invalid @enderror" name="ciudad" id="ciudad" required>
		    @if(empty($cliente))
		  		<option value="" selected>Seleccione la ciudad o municipio</option>
		  	@else
		  		<option value="{{{$cliente->ciudad}}}">{{ $cliente->ciudad }}</option>
		  	@endif
		</select>
		@error('state')
	  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
	  	@enderror
	</div>
<!-- Foto de la empresa cliente -->
	<div class="mb-3 mb-3 col-md-5">
	  <label for="photo" class="form-label">Imagen</label>
	  <input class="form-control @error('imagen') is-invalid @enderror" type="file" photo="photo" name="imagen" id="photo"  onchange="photoBanner();"
	  {{$action = empty($cliente->imagen) ? 'required' : ''}}>
	  @error('imagen')
	  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
	  	@enderror
	</div>
<!-- Estado del cliente -->
	<div class="mb-3 mb-3 col-md-5">
		<label for="state" class="form-label">Estado del cliente</label>
		<select class="form-select @error('estado') is-invalid @enderror" name="estado" id="state" required>
			@if(empty($cliente))
			  <option value="" selected>Seleccione el estado</option>
			  <option value="1" {{ old("state") == 1 ? "selected" : " " }}>Activo</option>
			  <option value="0">Inactivo</option>
		  	@elseif($cliente->estado == 1)
		  	  <option value="1" {{ old("state") == 1 ? "selected" : " " }}>Activo</option>
			  <option value="0">Inactivo</option>
			@else
			  <option value="0" {{ old("state") == 1 ? "selected" : " " }}>Inactivo</option>
			  <option value="1">Activo</option>
			@endif
		</select>
		@error('estado')
	  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
	  	@enderror
	</div>
	<div class="mb-3 mb-3 col-md-12 d-md-flex justify-content-md-end">
		<button  class="btn btn-primary mx-2" type="submit">{{ $btntxt }}</button>
		<a  class="btn btn-success" href="{{ URL::previous() }}" role="button">
    		Volver
		</a>
	</div>
<ul>
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
</ul>
</div>
