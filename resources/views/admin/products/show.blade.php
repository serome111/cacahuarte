@extends('layout-dashboard')

@section('title','Cacahuarte')

@section('content')
<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">
<style type="text/css">
h4 {display: inline;}
</style>
	{{-- {{$product}} --}}
	<div class="card">
	  	<div class="row g-0 p-5">
		  	<div class="col-md-5">
			    <img src="{{ $product->picture }}" alt="{{ $product->name }}" height="350" width="400">
			</div>
			<div class="col-md-4">
				<form class="dropdown-item" id="producdelete" method="POST" action="{{ route('products.destroy', $product ) }}">
					@csrf @method('DELETE')
				</form>
				<h3 class="card-title">{{ $product->name }}</h3>
			    <h5 class="card-subtitle mb-2 text-muted">Ref: {{ $product->code }}</h5>
			    <h3>Inventario disponible</h3>
			    <h1> # {{ $product->stock }} </h1>
			    <h4>Precio de venta</h4>
			    <h2> $ {{ $product->price }} </h2>
			    <p class="card-text">{{ $product->description }}</p>
			    <h4><a class="badge rounded-pill btn btn-warning text-dark" href="{{route('products.edit', $product )}}">Editar Producto</a></h4>
			    <h4><button class="badge rounded-pill btn btn-danger text-dark" form="producdelete">Eliminar Producto</button></h4>
			</div>
	  	</div>
		<div class="card-footer text-muted">
			ultima edicion {{ $product->updated_at }}
		</div>
	</div>
</main>
@endsection()