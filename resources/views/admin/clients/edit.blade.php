@extends('layout-dashboard')

@section('title','Cacahuarte')

@section('content')

<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">

<div class="content py-3 px-4">
	<form method="POST" action="{{ route('clients.update', $cliente->id) }}" enctype="multipart/form-data">
		@csrf @method('PATCH')
		@include('admin.clients.__form',['btntxt'=>'Guardar cambios'])
	</form>
</div>
<div class="card shadow col-6 mx-auto" style="height: 200px; background:transparent url(
	{{$action = empty('/images/clients/'.$cliente->imagen) ? '/images/hero-bg.jpg?ac74f1c3aff13b2b4d2e539f276dece2' : '/images/clients/'.$cliente->imagen
}}) no-repeat center center /cover;" id="bannerDiv">
{{-- /images/hero-bg.jpg?ac74f1c3aff13b2b4d2e539f276dece2 --}}
</div>

@endsection()