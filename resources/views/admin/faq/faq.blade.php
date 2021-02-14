@extends('layout-dashboard')

@section('title','Cacahuarte')

@section('content')
<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">

<div class="content py-3">
	<div class="d-grid gap-2 d-md-flex justify-content-md-end">
	<a href="{{ route('faq.create') }}" class="nav-link">
		<button type="submit" class="btn btn-secondary">Nuevo Pregunta frecuente</button>
	</a>
	</div>


	@if(count($faqs))
		@foreach($faqs as $faq )
			@if($faq->link == 0)
				<div class="accordion" id="{{$faq->id}}">
				  	<div class="accordion-item">
				    	<h2 class="accordion-header" id="headingOne">
					    	<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#x{{$faq->id}}" aria-expanded="true" aria-controls="collapseOne">
					        {{$faq->question}}
					      	</button>
				    	</h2>
				    	<div id="x{{$faq->id}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#{{$faq->id}}">
					      	<div class="accordion-body">
					       		{{$faq->solution}}
					      	</div>
						    <div class="position-relative">
						      	<form class="dropdown-item" id="faq{{$faq->id}}" method="POST" action="{{ route('faq.destroy', $faq->id ) }}">
									@csrf @method('DELETE')
									<button class="btn btn-danger position-absolute bottom-0 end-0" form="faq{{$faq->id}}">Eliminar pregunta</button>
							  	</form>
						    </div>
				    	</div>
					</div>
				</div>

			@else
				<div class="accordion" id="{{$faq->id}}">
				 	<div class="accordion-item">
				    	<h2 class="accordion-header" id="headingOne">
				      		<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#x{{$faq->id}}" aria-expanded="true" aria-controls="collapseOne">
				        {{$faq->question}}
				      	</button>
				   		 </h2>
				    <div id="x{{$faq->id}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#{{$faq->id}}">
				      <div class="accordion-body">
				       {{$faq->solution}}
				       <a href="{{$faq->link}}" class="details-link" title="Mas detalles"><i class="bx bx-link">{{$faq->textLink}}</i></a>
				      </div>
				      <div class="position-relative">
				      	<form class="dropdown-item" id="faq{{$faq->id}}" method="POST" action="{{ route('faq.destroy', $faq->id ) }}">
							@csrf @method('DELETE')
							<button class="btn btn-danger position-absolute bottom-0 end-0" form="faq{{$faq->id}}">Eliminar pregunta</button>
					  	</form>
				      </div>
				    </div>
				  </div>
				</div>
			@endif

			<br>
		@endforeach
	@else
		<h1>No existen preguntas frecuentes</h1>
	@endif


	<br><br>


</div>
</main>
@endsection()