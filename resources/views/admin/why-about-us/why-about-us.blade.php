@extends('layout-dashboard')

@section('title','Cacahuarte')


@section('content')

<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">

<div class="row">
	<h2 >Tarjetas</h2>
	<div class="col-lg-6">
		<a  class="btn btn-primary" href="{{ route('why-about-us.create') }}" role="button">
		  Nueva Tarjeta
		</a>
	</div>

<div class="row row-cols-1 row-cols-md-2 g-4"> 
	@forelse($cardCompleta as $tarjeta)
		@if($tarjeta->id != null)
			<div class="col">
			    <div class="card text-center border-dark my-3" style="width: 18rem;">
				  <div class="card-header">
				  	<i class="{{ $tarjeta->icon_class }} icofont-3x mt-1"></i>
				  </div>
				  <div class="card-body">
				    <h5 class="card-title">{{ $tarjeta->title }}</h5>
				    <p class="card-text">{{$tarjeta->description}}</p>
				  </div>
				  <div class="card-body">
				    <a href="{{ route('why-about-us.edit', $tarjeta->id )}}" class="btn btn-success" rel="button">
				      Editar
					</a>
				    <!-- Button trigger modal -->
					<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
					  Eliminar
					</button>
				  </div>
				  @if($tarjeta->state == 1)
				  	<div class="card-footer bg-primary bg-gradient text-light">
					  Activo
				  	</div>
				  @else
				  	<div class="card-footer text-light bg-gradient" style="background-color: red;">
					  Inactivo
				  	</div>
				  @endif
				</div>
		    </div>
	@endif
		@empty
			<p class="text-muted h5">No hay tarjetas para mostrar</p>
		@endforelse
	</div>

<!-- Modal -->
<div class="modal fade modal-sm" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-left: 500px; ">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Eliminando Tarjeta...</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="text-dark">¿Desea eliminar esta tarjeta? Esta no podrá recuperarse</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <form method="POST" action="{{ route('why-about-us.destroy', $tarjeta->id) }}">@csrf @method('DELETE')
			<button class="btn btn-danger">Eliminar</button> 
	    </form>
      </div>
    </div>
  </div>
</div>
</main>

@endsection()
