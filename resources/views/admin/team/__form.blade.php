<div class="row d-flex justify-content-center">
	<div class="col-lg-6 col-md-6 d-flex">
		<div class="card">
			<div class="text-center">
				<img src="{{ empty($team->imagen) ? url('img/avatar.png') : url('images/team/'.$team->imagen) }}" class="img-fluid mt-3" alt="Imagen del integrante" height="100" width="100" id="avatar">
			</div>
		    <div class="card-body">
		      <label for="formFile" class="form-label">Seleccione una imagen</label>
		      <input type="file" class="form-control" name="imagen" id="imagen" value="{{ old('imagen',$team->imagen) }}" onchange="fotoTeam()" required>
		      @error('imagen')
			  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
			  @enderror
		      <label for="formText" class="form-label">Nombre</label>
		      <input type="text" class="form-control" name="nombre" value="{{ old('nombre',$team->nombre) }}" required>
		      @error('nombre')
			  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
			  @enderror
		      <label for="formtext" class="form-label">Apellido</label>
		      <input type="text" class="form-control" name="apellido" value="{{ old('apellido',$team->apellido) }}" required>
		      @error('apellido')
			  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
			  @enderror
		      <label for="formtext" class="form-label">Cargo</label>
		      <input type="text" class="form-control" name="cargo" value="{{ old('cargo',$team->cargo) }}" required>
		      @error('cargo')
			  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
			  @enderror
		      @if($team->estado == 1)
			      <select name="estado" class="form-control mt-2" required>
			      	<option value="1">Activo</option>
			      	<option value="2">Inactivo</option>
			      </select>
		      @elseif($team->estado == 2)
			      <select name="estado" class="form-control mt-2" required>
			      	<option value="2">Inactivo</option>
			      	<option value="1">Activo</option>
			      </select>
		      @else
			      <select name="estado" class="form-control mt-2" required>
			      	<option value="">Selecciona un estado</option>
			      	<option value="1">Activo</option>
			      	<option value="2">Inactivo</option>
			      </select>
			      @error('estado')
				  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
				  @enderror
		      @endif
		      <button  class="btn btn-primary my-2" type="submit">{{ $btntxt }} <i class="icofont-checked"></i></button>
		      <a href="{{ URL::previous() }}"  class="btn btn-secondary my-2" role="button">Volver <i class="icofont-reply"></i></a>
		    </div>
		</div>
	</div>
</div>

