@extends('layout-dashboard')

@section('title','Cacahuarte')

@section('content')

<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">
	<div class="content py-3 px-4">
		<form method="POST" action="{{ route('values.update', $values) }}" enctype="multipart/form-data">
			@csrf @method('PATCH')
			@include('admin.values.__form',['btntxt'=>'Editar'])
		</form>
	</div>

	@include('admin.values.partials.cardValue',['photo'=>$values->picture,'title'=>$values->title,'description'=>$values->description])
</main>
@endsection()