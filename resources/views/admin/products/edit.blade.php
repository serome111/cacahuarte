@extends('layout-dashboard')

@section('title','Cacahuarte')

@section('content')
<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">
<div class="card">
  	<h5 class="card-header"><span data-feather="edit"></span>Editar producto</h5>
  	<div class="card-body">
	   	<div class="content py-3 px-4">
			<form method="POST" action="{{ route('products.update', $products) }}" enctype="multipart/form-data">
				@csrf @method('PATCH')
				@include('admin.products.__form',['btntxt'=>'Editar Producto'])
			</form>
		</div>
  	</div>
</div>
</main>
@endsection()