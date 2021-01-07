@extends('layout-dashboard')

@section('title','Cacahuarte')

@section('content')

<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">

<div class="content py-3 px-4">
	<form method="POST" action="{{ route('banner.update', $banners) }}" enctype="multipart/form-data">
		@csrf @method('PATCH')
		@include('admin.banner.__form',['btntxt'=>'Editar banner'])
	</form>
</div>

@include('admin.banner.partials.cardBanner',['photo'=>$banners->photo,'title'=>$banners->title,'description'=>$banners->description])

@endsection()