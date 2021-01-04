@extends('layout-dashboard')

@section('title','Cacahuarte')

@section('content')

<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">

<form method="POST" action="{{ route('banner.store') }}">
	@csrf
	@include('admin.banner.__form',['btntxt'=>'Crear banner'])
</form>

</main>

@endsection()
