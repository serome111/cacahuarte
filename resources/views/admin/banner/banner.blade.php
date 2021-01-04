@extends('layout-dashboard')

@section('title','Cacahuarte')




@section('content')

<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">

<div class="row">
	banners
	<a href="{{ route('banner.create') }}" class="nav-link">
		<div class=" d-grid gap-2 d-md-flex justify-content-md-end">
	    	<div class="card">
	     		<div class="card-body">
	        		<h5 class="card-title">Nuevo Banner</h5>
	      		</div>
	    	</div>
	  	</div>
	</a>



@forelse($banners as $banner)
	@if($banner->state == 1)
	<div class="col-sm-6">
	<div class="card" style="background:transparent url(/images/hero-bg.jpg?ac74f1c3aff13b2b4d2e539f276dece2) no-repeat center center /cover">
	 	<div class="card-body">
	    	<h5 class="card-title">{{ $banner->title }}</h5>
	    	<p class="card-text">{{ $banner->description }}</p>
			<p class="card-text"><span class="badge bg-warning text-dark">{{ $banner->button }}</span></p>
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
	        <h5 class="card-title">{{ $banner->title }}</h5>
	        <p class="card-text">{{ $banner->description }}</p>
	        <p class="card-text"><span class="badge bg-warning text-dark">{{ $banner->button }}</span></p>
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
			<li>No hay usuarios para mostrar</li>
		@endforelse
	</ul>

</main>

@endsection()
