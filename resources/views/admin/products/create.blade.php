@extends('layout-dashboard')

@section('title','Cacahuarte')

@section('content')
<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">
<div class="card">
  <h5 class="card-header"><span data-feather="edit"></span> Agregar nuevo producto</h5>
  <div class="card-body">
   	<div class="content py-3 px-4">
		<form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
			@csrf
			@include('admin.products.__form',['btntxt'=>'Crear Producto'])
		</form>
	</div>
  </div>
</div>


</main>
@endsection()