@extends('layout-dashboard')

@section('title','Cacahuarte')

@section('content')

<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">

	<form method="POST" action="{{ route('why-about-us.store') }}">
		@csrf
		@include('admin.why-about-us.__form',['btntxt'=>'Crear tarjeta'])
	</form>

</main>

@endsection()
