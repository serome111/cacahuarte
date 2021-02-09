@extends('layout-dashboard')

@section('title','Cacahuarte')

@section('content')

<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">
<h1 class="display-4 text-center"> Equipo de trabajo </h1>
<p class="h5 text-center text-muted mb-5"> Aquí puedes administrar el equipo de trabajo </p>
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
	<a href="{{ route('team.create') }}" class="btn btn-primary" rel="button">
		<i class="icofont-plus-circle"></i> Nuevo integrante
	</a>
</div>
<div class="row">
@forelse($team as $miembro)
	@if($miembro->state == 1)
	<div class="col-sm-4 mx-auto">
		<div class="card shadow mb-5 mx-auto">
			<div class="d-grid gap-2 d-md-flex justify-content-md-end">
			  <button class="btn btn-success disabled me-md-2 btn-sm rounded-pill position-absolute top-0 start-100 translate-middle" type="button">Activo</button>
			</div>
			<div class="text-center">
				<img src="{{url('images/team/'.$miembro->imagen)}}" class="img-fluid mt-3" alt="Imagen del integrante" height="200" width="200">
			</div>
		 	<div class="card-body text-center">
		 	  <h5 class="card-title">{{ $miembro->name }}</h5>
		 	  <h5 class="card-title">{{ $miembro->lastName }}</h5>
		 	  <h5 class="card-text">{{ $miembro->position }}</h5>
			  <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
			    Accion
			  </button>
			  <ul class="dropdown-menu">
			    <li>
			    	<a class="dropdown-item text-success" href="{{ route('team.edit',$miembro->id) }}">
			    		<i class="icofont-edit"></i> Editar
			    	</a>
			    </li>
			    <li>			    	
			    	<a type="button" class="btn text-danger" data-bs-toggle="modal" data-bs-target="#exampleModal1">
			    		<i class="icofont-garbage"></i> Eliminar
			    	</a>
				</li>
			  </ul>
			</div>
		</div>
	</div>
			<!-- Modal -->
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Eliminando...</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>¿Realmente desea elimiar este integrante? Una vez hecho no se podrá recuperar.</p>
      </div>
      <div class="modal-footer">
        <form  class="dropdown-item" id="banner" method="POST" action="{{ route('team.destroy', $miembro->id) }}">	
        	@csrf @method('DELETE')
	        <a rel="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</a>
        	<button type="submit" class="btn btn-primary">Eliminar</button>
		</form>
      </div>
    </div>
  </div>
</div>
	@else
	<div class="col-sm-4 mx-auto">
		<div class="card shadow mb-5 mx-auto">
			<div class="d-grid gap-2 d-md-flex justify-content-md-end">
			  <button class="btn btn-danger disabled me-md-2 btn-sm rounded-pill position-absolute top-0 start-100 translate-middle" type="button">Inactivo</button>
			</div>
			<div class="text-center">
				<img src="{{url('images/team/'.$miembro->imagen)}}" class="img-fluid mt-3" alt="Imagen del integrante" height="200" width="200">
			</div>
		 	<div class="card-body text-center">
		 	  <h5 class="card-title">{{ $miembro->name }}</h5>
		 	  <h5 class="card-title">{{ $miembro->lastName }}</h5>
		 	  <h5 class="card-text">{{ $miembro->position }}</h5>
			  <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
			    Accion
			  </button>
			  <ul class="dropdown-menu">
			    <li>
			    	<a class="dropdown-item" href="{{ route('team.edit',$miembro->id) }}">
			    		Editar
			    	</a>
			    </li>
			    <li>			    	
			    	<a type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
			    		Eliminar
			    	</a>
				</li>
			  </ul>
			</div>
		</div>
	</div>
		<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Eliminando...</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>¿Realmente desea elimiar este integrante? Una vez hecho no se podrá recuperar.</p>
      </div>
      <div class="modal-footer">
        <form  class="dropdown-item" id="banner" method="POST" action="{{ route('team.destroy', $miembro->id) }}">	
        	@csrf @method('DELETE')
	        <a rel="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</a>
        	<button type="submit" class="btn btn-primary">Eliminar</button>
		</form>
      </div>
    </div>
  </div>
</div>
	@endif

		@empty
			<li>No hay nada de equipo</li>
		@endforelse
	</ul>	
</main>
@endsection()
