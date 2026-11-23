@extends('layout-dashboard')

@section('title','Cacahuarte')

@section('content')
<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">
<div class="content py-3">
	<div class="d-grid gap-2 d-md-flex justify-content-md-end">
	<a href="{{ route('products.create') }}" class="nav-link">
		<button type="submit" class="btn btn-secondary">Nuevo producto</button>
	</a>
	</div>
	<form action="{{ route('products.index') }}" method="GET" class="row g-3">
		<div class="col-sm-6">
		  <label for="Codefilter" class="form-label">Buscar producto por nombre o codigo</label>
		  <input type="text" class="form-control" id="Codefilter" placeholder="referencia..." name="search" maxlength="255" value="{{ request('search') }}">
		</div>
		<div class="col-sm-3">
			<label for="catgriafilter" class="form-label">Filtrar por categoria</label>
			<select class="form-select" name="category" id="catgriafilter" aria-label="Default select example">
				<option value="">Categoria</option>
				@if($categories->count() === 0)
					<option value="">No existen categorias creadas</option>
				@else
					@foreach($categories as $categorie)
						<option value="{{$categorie->id}}" @selected((string) request('category') === (string) $categorie->id)>{{$categorie->name}}</option>
					@endforeach
				@endif
			</select>
		</div>
		<div class="col-sm-3">
			<label for="state" class="form-label">Filtrar estado del producto</label>
			<select class="form-select" id="state" aria-label="Default select example" name="state">
			  <option value="">Estado</option>
			  <option value="1" @selected(request('state') === '1')>Activo</option>
			  <option value="0" @selected(request('state') === '0')>Inactivo</option>
			</select>
		</div>
        <div class="col-12">
            <button type="submit" class="btn btn-secondary">Filtrar</button>
            <a href="{{ route('products.index') }}" class="btn btn-link">Limpiar</a>
        </div>
    </form>

</div>


<div class="row row-cols-1 row-cols-md-5 g-3">
	@forelse($products as $product)
		<div class="col">
			<div class="card position-relative">
				<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary">{{$product->stock}}<span class="visually-hidden">cantidad</span></span>
				<a href="{{ route('products.show',$product ) }}">
			     <img src="{{$product->picture}}" class="card-img-top" alt="{{$product->id}}" height="140">
			    </a>
				<div class="card-body text-center">
				    <h5 class="card-title">{{$product->name}}</h5>
				    <p class="card-text">Codigo: {{$product->code}}</p>
				</div>

			    @if($product->state === 0)
				<div class="position-absolute bottom-0 start-50 translate-middle-x badge rounded-pill bg-danger">Inactivo</div>
			    @endif
			</div>
		</div>
	@empty
        <p>No se encontraron productos.</p>
	@endforelse
</div>
<div class="d-flex justify-content-center my-4">
    {{ $products->links() }}
</div>


</main>

@endsection
