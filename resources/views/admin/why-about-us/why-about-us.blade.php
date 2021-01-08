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
	



@forelse($tarjetas as $tarjeta)
	@if($tarjeta->state == 1)
	<div class="col-sm-6">
	<div class="card" style="background:transparent url(/images/hero-bg.jpg?ac74f1c3aff13b2b4d2e539f276dece2) no-repeat center center /cover">
	 	<div class="card-body">
	    	<h5 class="card-title">{{ $tarjeta->title }}</h5>
	    	<p class="card-text">{{ $tarjeta->description }}</p>
			<p class="card-text"><span class="badge bg-warning text-dark">{{ $tarjeta->button }}</span></p>
	        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
	  			<button class="btn btn-warning me-md-2" type="button">Editar</button>
	  			<button class="btn btn-danger" type="button">Eliminar</button>
			</div>
	  	</div>
	</div>
	<div class="card-footer bg-success">
		Activo
	</div>
</div>
	@else
	<div class="col-sm-6">
    <div class="card" style="background:transparent url(/images/hero-bg.jpg?ac74f1c3aff13b2b4d2e539f276dece2) no-repeat center center /cover">
	      <div class="card-body">
	        <h5 class="card-title">{{ $tarjeta->title }}</h5>
	        <p class="card-text">{{ $tarjeta->description }}</p>
	        <p class="card-text"><span class="badge bg-warning text-dark">{{ $tarjeta->button }}</span></p>
	        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
	  			<button class="btn btn-warning me-md-2" type="button">Editar</button>
	  			<button class="btn btn-danger" type="button">Eliminar</button>
			</div>
	      </div>
	    </div>
	    <div class="card-footer">
	    	-
	  	</div>
	  </div>


	@endif
		@empty
			<p class="text-muted h5">No hay tarjetas para mostrar</p>
		@endforelse
	</ul>

</main>

@endsection()
