@extends('layout-dashboard')

@section('title','Cacahuarte')

@section('content')

<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">

<div class="content py-3 px-4">
	<form method="POST" action="{{ route('team.update', $team->id) }}" enctype="multipart/form-data">
		@csrf @method('PATCH')
		@include('admin.team.__form',['btntxt'=>'Guardar cambios'])
	</form>
</div>

@endsection()