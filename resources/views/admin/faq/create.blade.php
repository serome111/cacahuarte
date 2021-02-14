@extends('layout-dashboard')

@section('title','Cacahuarte')

@section('content')

<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">

<div class="card">
  <h5 class="card-header"><span data-feather="edit"></span>Crear nueva pregunta frecuente</h5>
  <div class="card-body">
   	<div class="content py-3 px-4">
		<form method="POST" action="{{ route('faq.store') }}" enctype="multipart/form-data">
			@csrf
			@include('admin.faq.__form',['btntxt'=>'Crear Pregunta frecuente'])
		</form>
	</div>
  </div>
</div>
</main>
@endsection()
