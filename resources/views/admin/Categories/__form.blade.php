<div class="form-group mx-auto">
	<label for="nombre" class="col-sm-12 control-label">
		Nombre de la categoría
	</label>
		<div class="col-sm-12">
		 	<input type="text" class="form-control" id="name" name="name" value="{{ old('name',$na = empty($categorie->name) ? '' : $categorie->name) }}"required>
		</div>
	@error('name')
		<span class="invalid-feedback" role="alert">
			<strong>{{$message}}</strong>
		</span>
	 @enderror
</div>
<div class="form-group">
	<label for="descripcion" class="col-sm-12 control-label">
		Descripción de la cagoría
	</label>
	<div class="col-sm-12">
		<textarea class="form-control" id="description" name="description" maxlength="255" required>{{ old('description',$des = empty($categorie->description) ? '' : $categorie->description) }}</textarea>
	</div>
	@error('description')
		<span class="invalid-feedback" role="alert">
			<strong>{{$message}}</strong>
		</span>
	 @enderror
</div>