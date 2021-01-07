@extends('layout-dashboard')

@section('title','Cacahuarte')

@section('content')

<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">


<div class="content py-3 px-4">
		<form method="POST" action="{{ route('banner.store') }}" enctype="multipart/form-data">
			@csrf
			@include('admin.banner.__form',['btntxt'=>'Crear banner'])
		</form>
</div>
@include('admin.banner.partials.cardBanner')

</main>
@endsection()
