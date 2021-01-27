@extends('layout-dashboard')

@section('title','Cacahuarte')

@section('content')

<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">
<div class="row">
		@forelse($values as $value)
		@if($value->state == 1)
			<div class="col-sm-6 mb-5">
				<div class="card shadow" style="height: 200px; background:transparent url({{$value->picture}}) no-repeat center center /cover">
				 	<div class="card-body">
				 		<div class="d-grid gap-2 d-md-flex justify-content-md-end">
							<button class="btn btn-success disabled me-md-2 btn-sm rounded-pill position-absolute top-0 start-100 translate-middle" type="button">Activo</button>
						</div>
						<div class=" d-grid gap-2 d-md-flex justify-content-md-end">
							<a href="{{ route('values.edit', $value) }}">
								<button type="button" class="btn btn-danger">
									Editar
								</button>
							</a>
						</div>
						<div class="card border-0 bg-transparent">
						    <br><br>
						</div>
						<div class="card text-center" style=" opacity: .8;">
					        <h5 class="card-title"><a href="">{{$value->title}}</a></h5>
					        <p class="card-text">{{$value->description}}</p>
				  		</div>
					</div>
				</div>
			</div>
		@else
			<div class="col-sm-6 mb-5">
				<div class="card shadow" style="height: 200px; background:transparent url({{$value->picture}}) no-repeat center center /cover">
				 	<div class="card-body">
				 		<div class="d-grid gap-2 d-md-flex justify-content-md-end">
							<button class="btn btn-danger disabled me-md-2 btn-sm rounded-pill position-absolute top-0 start-100 translate-middle" type="button">Inactivo</button>
						</div>
						<div class=" d-grid gap-2 d-md-flex justify-content-md-end">
							<a href="{{ route('values.edit', $value) }}">
								<button type="button" class="btn btn-danger">
									Editar
								</button>
							</a>
						</div>
						<div class="card border-0 bg-transparent">
						    <br><br>
						</div>
						<div class="card text-center" style=" opacity: .8;">
					        <h5 class="card-title"><a href="">{{$value->title}}</a></h5>
					        <p class="card-text">{{$value->description}}</p>
				  		</div>
					</div>
				</div>
			</div>
		@endif
			@empty
				<li>No hay ningun </li>
			@endforelse
		</ul>
</div>
</main>
@endsection()
