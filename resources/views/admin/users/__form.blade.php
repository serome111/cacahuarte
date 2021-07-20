<div class="form-group mx-auto">
	<label for="nombre" class="col-sm-12 control-label">
		Nombre del nuevo usuario
	</label>
		<div class="col-sm-12">
		 	<input type="text" class="form-control" id="name" name="name" value="{{ old('name',$n1 = empty($users->name) ? '' : $users->name) }}"required>
		</div>
	@error('name')
		<span class="invalid-feedback" role="alert">
			<strong>{{$message}}</strong>
		</span>
	 @enderror
</div>
<div class="form-group mx-auto">
	<label for="rol" class="col-sm-12 control-label">
		Seleccione el rol del usuario
	</label>
	<select class="form-select" name="rol" id="rol" aria-label="Default select example" required>
	  	<option value="" selected>Roles</option>
	  	@foreach($roles as $role)
			<option value="{{$role->id}}">{{$role->name}}</option>
		@endforeach
	</select>
</div>
<div class="form-group mx-auto">
	<label for="nombre" class="col-sm-12 control-label">
		Correo
	</label>
		<div class="col-sm-12">
		 	<input type="text" class="form-control" id="email" name="email" value="{{ old('email',$na = empty($users->email) ? '' : $users->email) }}"required>
		</div>
	@error('email')
		<span class="invalid-feedback" role="alert">
			<strong>{{$message}}</strong>
		</span>
	 @enderror
</div>
<div class="form-group mx-auto">
	<label for="nombre" class="col-sm-12 control-label">
		Contraseña
	</label>
		<div class="col-sm-12">
		 	<input type="password" class="form-control" id="password" name="password" value="{{ old('password',$n2 = empty($users->password) ? '' : $users->password) }}"required>
		</div>
	@error('password')
		<span class="invalid-feedback" role="alert">
			<strong>{{$message}}</strong>
		</span>
	 @enderror
</div>