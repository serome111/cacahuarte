@extends('layout-dashboard')

@section('title','Cacahuarte')

@section('content')
<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
	<button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">
	  Agregar un usuarios al sistema<span data-feather="plus-circle"></span>
	</button>
	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog ">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel"><span data-feather="plus-circle"></span> Agregar un nuevo usuario en el sistema</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	      	<form method="POST" id="CagoriesForm" action="{{ route('users.store') }}">
	      	@csrf
	      	@include('admin.users.__form')
			</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
	        <button type="submit" form="CagoriesForm" class="btn btn-primary">Guardar Categoria</button>
	      </div>
	    </div>
	  </div>
	</div>

</div>

<div class="content my-5">
	<table class="table table-responsive">
	  <thead class="table-light">
	     <tr>
	      <td colspan="4">
	          Nombre
	      </td>
	      <td colspan="4">
	          rol
	      </td>
	      <td colspan="4">
	          correo
	      </td>
	      <td colspan="4">
	          Fecha de Registro
	      </td>
	      <td colspan="4">
	          Acciones
	      </td>
	    </tr>
	  </thead>
  <tbody>
  	@foreach($users as $user)
	  	<form id="dCategorie" method="POST" action="{{ route('users.destroy', $user) }}">
			@csrf @method('DELETE')
		</form>
		<form id="eCategorie" method="POST" action="{{ route('users.destroy', $user) }}">
			@csrf @method('PATCH')
		</form>
	    <tr>
	    	<td colspan="4">
	      		{{$user->name}}
	      	</td>
	      	<td colspan="4"	>
	      		{{$user->role->name}}
	      	</td>
	      	<td colspan="4"	>
	      		{{$user->email}}
	      	</td>
	      	<td colspan="4"	>
	      		{{$user->created_at}}
	      	</td>
	      	<td colspan="4"	>
	      		<button type="button" form="eCategorie" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit{{$user->id}}">
		  			<span data-feather="edit"></span>
				</button>
		      	<button type="submit"  form="dCategorie" class="btn btn-danger">
		  			<span data-feather="trash-2"></span>
				</button>
	      	</td>
	    </tr>
	    <!-- Modal -->
		<div class="modal fade" id="edit{{$user->id}}" tabindex="-1" aria-labelledby="editc" aria-hidden="true">
		  <div class="modal-dialog ">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="editc"><span data-feather="edit-3"></span> Editar Usuario</h5>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      <div class="modal-body">
		      	<form method="POST" id="CagoriesForm{{$user->id}}" action="{{ route('categories.update',$user) }}">
		      	@csrf @method('PATCH')
		     		<div class="form-group mx-auto">
						<label for="nombre" class="col-sm-12 control-label">
							Nombre del nuevo usuario
						</label>
							<div class="col-sm-12">
							 	<input type="text" class="form-control" id="name{{$user->id}}" name="name" value="{{ $user->name }}"required>
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
						<select class="form-select" name="rol" id="rol{{$user->id}}" aria-label="Default select example" required>
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
							<div class=" form-group  col-sm-12">
							 	<input type="text" class="form-control" id="email{{$user->id}}" name="email" value="{{$user->email}}" required>
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
								<input type="password" class="form-control" id="password{{$user->id}}" name="password" value="" required>
							</div>
						@error('password')
							<span class="invalid-feedback" role="alert">
								<strong>{{$message}}</strong>
							</span>
						 @enderror
					</div>
				</form>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
		        <button type="submit" form="CagoriesForm{{$user->id}}" class="btn btn-primary">Guardar Categoria</button>
		      </div>
		    </div>
		  </div>
		</div>
    @endforeach

  </tbody>
</table>
</div>
</main>
@endsection()