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
	<div class="row g-3">
		<div class="col-sm-6">
		  <label for="Codefilter" class="form-label">Buscar producto por nombre o codigo</label>
		  <input type="text" class="form-control" id="Codefilter" placeholder="referencia..." onkeyup="filter(this);">
		</div>
		<div class="col-sm-3">
		  	<label for="catgriafilter" class="form-label">Filtrar por categoria</label>
		  	<select class="form-select" name="catgriafilter" id="catgriafilter" aria-label="Default select example" onchange="filter(2);">
			  <option value="" selected>Categoria</option>
			  @if($categories->count() === 0)
			  <option value="">No existen categorias creadas</option>
			@else
				@foreach($categories as $categorie)
			  		<option value="{{$categorie->id}}">{{$categorie->name}}</option>
			  	@endforeach
		  	@endif

			</select>
		</div>
		<div class="col-sm-3">
		  	<label for="exampleFormControlInput1" class="form-label">Filtrar estado del producto</label>
		  	<select class="form-select" id="state" aria-label="Default select example" onchange="filter(1);">
			  <option value="" selected>Estado</option>
			  <option value="1">Activo</option>
			  <option value="0">Inactivo</option>

			</select>
		</div>
	</div>

	</div>


<div class="row row-cols-1 row-cols-md-5 g-3">
	@foreach($products as $product)
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
	@endforeach
</div>
<div class="d-flex justify-content-center my-4">
    {{ $products->links() }}
</div>


</main>

<script type="text/javascript">
	function filter(value){
		window.CSRF_TOKEN = '{{ csrf_token() }}';
		if(value == 0){
			category = document.getElementById("catgriafilter").value;
		}else if(value == 1){
			state = document.getElementById("state").value;
		}else{
			// let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
			var datos = new FormData();
			datos.append('code', value);
			// console.log(datos)
			fetch('{{ route('filter') }}',{
				headers: {
       				'X-CSRF-TOKEN': window.CSRF_TOKEN// <--- aquí el token
    			},
				method: 'POST',
				body: datos
			 })
			.then( res => res.text())
			.then( data => {
				console.log(data);
			}).catch(error =>{
				console.log(error)
			  console.log('Se ha encontrado un error en el archivo o web que se hace la peticion');
			})

		}

	}


</script>
@endsection()