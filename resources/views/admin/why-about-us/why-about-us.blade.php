@extends('layout-dashboard')

@section('title','Cacahuarte')


@section('content')

<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">
	<h2 class="text-center display-4">Tarjetas</h2>
	<p class="text-center text-muted h3">Aquí puede editar el contenido de las tarjetas informativas</p>
	<div class="row mx-5">
		@forelse($cardCompleta as $tarjeta)
			@if($tarjeta->id != null)
				<div class="col-lg-6">
				    <div class="card text-center border-dark my-3" style="width: 18rem;">
					  <div class="card-header">
					  	<i class="{{ $tarjeta->icon_class }} icofont-3x mt-1"></i>
					  </div>
					  <div class="card-body">
					    <h5 class="card-title">{{ $tarjeta->title }}</h5>
					    <p class="card-text">{{$tarjeta->description}}</p>
					  </div>
					  <div class="card-footer">
					    <a href="{{ route('why-about-us.edit', $tarjeta->id )}}" class="btn btn-success" rel="button">
					      Editar
						</a>
					  </div>
					</div>
			    </div>
		    @endif
			@empty
				<p class="text-muted h5">No hay tarjetas para mostrar</p>
		@endforelse
	</div>
</main>

@endsection
