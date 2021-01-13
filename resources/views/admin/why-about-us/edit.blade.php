@extends('layout-dashboard')

@section('title','Cacahuarte')

@section('content')

<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">
@foreach($tarjetas as $tarjeta)
	<form method="POST" action="{{ route('why-about-us.update',$tarjeta->id) }}">
		@csrf  
		@method('PUT')
		@include('admin.why-about-us.__form',['btntxt'=>'Guardar cambios'])

	</form>
@endforeach
</main>

@endsection()
