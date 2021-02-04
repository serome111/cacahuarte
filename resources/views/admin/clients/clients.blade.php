@extends('layout-dashboard')

@section('title','Cacahuarte')

@section('content')

<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">
<h1 class="display-4 text-center"> Nuestros Clientes </h1>
<p class="h5 text-center text-muted mb-5"> Aquí puedes administrar los clientes </p>
<div class="row">
@forelse($clientes as $cliente)
	@if($cliente->estado == 1)
	<div class="col-sm-6 mx-auto">
	<div class="card shadow mb-5 mx-auto" style="height: 200px; background:transparent url({{ '/images/clients/'.$cliente->imagen }}) no-repeat center center /cover">
	 	<div class="card-body">
	 		<div class="d-grid gap-2 d-md-flex justify-content-md-end">
			  <button class="btn btn-success disabled me-md-2 btn-sm rounded-pill position-absolute top-0 start-100 translate-middle" type="button">Activo</button>
			</div>
			<div class="position-absolute top-50 translate-middle-y">
				<h5 class="card-title" style="color: #fff;">{{ $cliente->nombreAlmacen }}</h5>
		    	<h6 class="card-text" style="color: #fff;">{{ $cliente->nombreRepresentante }}</h6>
		    	<h6 class="card-text" style="color: #fff;">{{ $cliente->correo }}</h6>
		    	<h6 class="card-text" style="color: #fff;">{{ $cliente->telefono }}</h6>
		    	<h6 class="card-text" style="color: #fff;">{{ $cliente->ciudad }} - {{ $cliente->departamento }}</h6>
	    	</div>
			<div class=" d-grid gap-2 d-md-flex justify-content-md-end">
			  <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
			    Accion
			  </button>

			  <ul class="dropdown-menu">
			    <li><a class="dropdown-item" href="{{ route('clients.edit',$cliente->id) }}">Editar</a></li>
			    <li>
			    	
			    	<a  type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal1">
			    		Eliminar
			    	</a>
				</li>
			  </ul>

			</div>

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
        <p>¿Realmente desea elimiar este cliente? Una vez hecho no se podrá recuperar.</p>
      </div>
      <div class="modal-footer">
        <form  class="dropdown-item" id="banner" method="POST" action="{{ route('clients.destroy', $cliente->id) }}">	
        	@csrf @method('DELETE')
	        <a rel="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</a>

        	<button type="submit" class="btn btn-primary">Eliminar</button>
		</form>
      </div>
    </div>
  </div>
</div>
	@else
	<div class="col-sm-6 mb-5 mx-auto">
	<div class="card shadow mx-auto" style="height: 200px; background:transparent url({{'/images/clients/'.$cliente->imagen }}) no-repeat center center /cover">
	 	<div class="card-body">
	 		<div class="d-grid gap-2 d-md-flex justify-content-md-end">
			  <button class="btn btn-danger disabled me-md-2 btn-sm rounded-pill position-absolute top-0 start-100 translate-middle" type="button">Inactivo</button>
			</div>
			<div class="position-absolute top-50 translate-middle-y">
				<h5 class="card-title" style="color: #fff;">{{ $cliente->nombreAlmacen }}</h5>
		    	<h6 class="card-text" style="color: #fff;">{{ $cliente->nombreRepresentante }}</h6>
		    	<h6 class="card-text" style="color: #fff;">{{ $cliente->correo }}</h6>
		    	<h6 class="card-text" style="color: #fff;">{{ $cliente->telefono }}</h6>
		    	<h6 class="card-text" style="color: #fff;">{{ $cliente->ciudad }} - {{ $cliente->departamento }}</h6>
	    	</div>
			<div class=" d-grid gap-2 d-md-flex justify-content-md-end">
			  <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
			    Accion
			  </button>
			  <ul class="dropdown-menu">
			    <li><a class="dropdown-item" href="{{ route('clients.edit',$cliente->id) }}">Editar</a></li>
			    <li><a  rel="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
			    		Eliminar
			    	</a>
			  </ul>
			</div>
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
        <p>¿Realmente desea elimiar este cliente? Una vez hecho no se podrá recuperar.</p>
      </div>
      <div class="modal-footer">
        <form  class="dropdown-item" id="banner" method="POST" action="{{ route('clients.destroy', $cliente->id) }}">	
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
			<li>No hay ningún cliente</li>
		@endforelse
	</ul>	
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
		<a href="{{ route('clients.create') }}" class="btn btn-primary" rel="button">
    		Nuevo Cliente
    	</a>
  	</div>
</main>
@endsection()
