@extends('layout-dashboard')

@section('title','Cacahuarte')

@section('content')

<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">

<div class="row">
@forelse($banners as $banner)
	@if($banner->state == 1)
	<div class="col-sm-6">
	<div class="card shadow mb-5 mx-auto" style="height: 200px; background:transparent url({{ $banner->photo }}) no-repeat center center /cover">
	 	<div class="card-body">
	 		<div class="d-grid gap-2 d-md-flex justify-content-md-end">
			  <button class="btn btn-success disabled me-md-2 btn-sm rounded-pill position-absolute top-0 start-100 translate-middle" type="button">Activo</button>
			</div>
			<div class="position-absolute top-50 translate-middle-y">
			<h5 class="card-title" style="color: #fff;">{{ $banner->title }}</h5>
	    	<p class="card-text" style="color: #fff;">{{ $banner->description }}</p></div>
			<div class=" d-grid gap-2 d-md-flex justify-content-md-end">
			  <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
			    Accion
			  </button>

			  <ul class="dropdown-menu">
			    <li><a class="dropdown-item" href="{{ route('banner.edit',$banner) }}">editar</a></li>
			    <li><form  class="dropdown-item" id="banner" method="POST" action="{{ route('banner.destroy', $banner) }}">@csrf @method('DELETE')</form>
			    	<button  class="dropdown-item" type="submit" form="banner" >Eliminar</button>
				</li>
			  </ul>

			</div>

	  	</div>
	</div>
</div>
	@else
	<div class="col-sm-6 mb-5">
	<div class="card shadow" style="height: 200px; background:transparent url({{ $banner->photo }}) no-repeat center center /cover">
	 	<div class="card-body">
	 		<div class="d-grid gap-2 d-md-flex justify-content-md-end">
			  <button class="btn btn-danger disabled me-md-2 btn-sm rounded-pill position-absolute top-0 start-100 translate-middle" type="button">Inactivo</button>
			</div>
			<div class="position-absolute top-50 translate-middle-y">
			<h5 class="card-title" style="color: #fff;">{{ $banner->title }}</h5>
	    	<p class="card-text" style="color: #fff;">{{ $banner->description }}</p>
	    	</div>
			<div class=" d-grid gap-2 d-md-flex justify-content-md-end">
			  <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
			    Accion
			  </button>
			  <ul class="dropdown-menu">
			    <li><a class="dropdown-item" href="{{ route('banner.edit',$banner) }}">editar</a></li>
			    <li><form  class="dropdown-item" id="banner" method="POST" action="{{ route('banner.destroy', $banner) }}">@csrf @method('DELETE')</form>
			    	<button  class="dropdown-item" type="submit" form="banner" >Eliminar</button></li>
			  </ul>
			</div>
	  	</div>
	</div>
</div>


	@endif
		@empty
			<li>No hay ningun banner</li>
		@endforelse
	</ul>
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
		<a href="{{ route('banner.create') }}" class="nav-link">
    		<button type="submit" class="btn btn-secondary">Nuevo Banner</button>
    	</a>
  	</div>
</main>
@endsection()
