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
		      <input type="text" class="form-control" name="name" value="{{ old('name',$team->name) }}" required>
		      @error('name')
			  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
			  @enderror
		      <label for="formtext" class="form-label">Apellido</label>
		      <input type="text" class="form-control" name="lastName" value="{{ old('lastName',$team->lastName) }}" required>
		      @error('lastName')
			  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
			  @enderror
		      <label for="formtext" class="form-label">Cargo</label>
		      <input type="text" class="form-control" name="position" value="{{ old('position',$team->position) }}" required>
		      @error('position')
			  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
			  @enderror
		      @if($team->state == 1)
			      <select name="state" class="form-control mt-2" required>
			      	<option value="1">Activo</option>
			      	<option value="2">Inactivo</option>
			      </select>
		      @elseif($team->state == 2)
			      <select name="state" class="form-control mt-2" required>
			      	<option value="2">Inactivo</option>
			      	<option value="1">Activo</option>
			      </select>
		      @else
			      <select name="state" class="form-control mt-2" required>
			      	<option value="">Selecciona un estado</option>
			      	<option value="1">Activo</option>
			      	<option value="2">Inactivo</option>
			      </select>
			      @error('state')
				  	<span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
				  @enderror
		      @endif
		      <button  class="btn btn-primary my-2" type="submit">{{ $btntxt }} <i class="icofont-checked"></i></button>
		      <a href="{{ URL::previous() }}"  class="btn btn-secondary my-2" role="button">Volver <i class="icofont-reply"></i></a>
		    </div>
		</div>
	</div>
</div>

