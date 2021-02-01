@extends('layout-dashboard')

@section('title','Cacahuarte')

@section('content')

<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">
<div class="card mb-3">
	{{ $ic = "",
	   $ic2 = "",
	   $ic3 = ""
	 }}
    <form method="POST" action="{{ route('about_us.update', $about_us) }}" enctype="multipart/form-data">
    	@csrf @method('PATCH')
		    <div class="row g-0">

			    <div class="col-md-4">
			    	{{-- /img/about-img.jpg --}}
			       	<img src="{{ $about_us->photo }}" id="photoAbout" alt="banner de video" width="380" height="560">
			        <div class="mb-3 mb-3 col-md-5">
					  <label for="photo" class="form-label">Imagen principal</label>
					  <input class="form-control @error('photo') is-invalid @enderror" type="file" name="photo" id="photo" value="{{ old('photo', $about_us->photo) }}" onchange="photos();">
					</div>
					<div class="mb-3">
					  <label for="exampleFormControlInput1" class="form-label">Link</label>
					  <input type="text" name='link' class="form-control @error('link') is-invalid @enderror" id="link" placeholder="link de youtube"value="{{ old('link', $about_us->link) }}">
					</div>
			    </div>

			    <div class="col-md-8">
			      	<div class="card-body">
						<div class="mb-3">
						  <label for="exampleFormControlInput1" class="form-label">Titulo principal</label>
						  <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Equipo de ...." value="{{ old('title', $about_us->title) }}">
						</div>
				        <div class="mb-3">
						  <label for="exampleFormControlInput1" class="form-label">Descripcion</label>
						  <textarea class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description', $about_us->description) }}</textarea>
						</div>

				        <div class="card mb-1 border-0" >
						  <div class="row g-0">
						    <div class="col-md-4">
						      	<select class="form-select @error('favicon1') is-invalid @enderror" aria-label="Default select example" id="select1" onchange="icon('select1');" name="favicon1">
								 	<option value="" selected>Seleccione un icono</option>
									@foreach( $icons as $icon)
										@if (old('favicon1',$about_us->favicon1) == $icon->id)
										    <option value="{{ $icon->id }}" selected>{{$icon->icon_name}} &#x{{$icon->icon_hex_code}}</option>
										    {{ $ic = $icon->icon_class }}
										@else
										    <option value="{{ $icon->id }}">{{$icon->icon_name}} &#x{{$icon->icon_hex_code}}</option>
										@endif
									@endforeach
								</select>
								<div class="d-flex justify-content-center">
									<i id="icon1" class="{{ $ic }} icofont-3x mt-1"></i>
								</div>
						    </div>
						    <div class="col-md-8">
						      <div class="card-body">
						        <div class="mb-3">
									<input type="text" class="form-control @error('title1') is-invalid @enderror" id="title1" name="title1" placeholder="Titulo 1" value="{{ old('title1', $about_us->title1) }}">
								</div>
						       <div class="mb-3">
								  <textarea class="form-control @error('description1') is-invalid @enderror" name="description1">{{ old('description1', $about_us->description1) }}
								  </textarea>
								</div>
						      </div>
						    </div>
						  </div>
						</div>

						<div class="card mb-1 border-0" >
						  <div class="row g-0">
						    <div class="col-md-4">
						      	<select class="form-select @error('favicon2') is-invalid @enderror" aria-label="Default select example" name="favicon2" id="select2" onchange="icon('select2');">
								  	<option value="" selected>Seleccione un icono</option>
									@foreach( $icons as $icon)
										@if (old('favicon2',$about_us->favicon2) == $icon->id)
										    <option value="{{ $icon->id }}" selected>{{$icon->icon_name}} &#x{{$icon->icon_hex_code}}</option>
										    {{ $ic2 = $icon->icon_class }}
										@else
										    <option value="{{ $icon->id }}">{{$icon->icon_name}} &#x{{$icon->icon_hex_code}}</option>
										@endif
									@endforeach
								</select>
								<div class="d-flex justify-content-center">
									<i id="icon2" class="{{ $ic2 }} icofont-3x mt-1"></i>
								</div>
						    </div>
						    <div class="col-md-8">
						      <div class="card-body">
						        <div class="mb-3">
								  <input type="text" class="form-control @error('title2') is-invalid @enderror" id="title2" name="title2" placeholder="Titulo 2" value="{{ old('title2', $about_us->title2) }}">
								</div>
						       <div class="mb-3">
								  <textarea class="form-control @error('description2') is-invalid @enderror" name="description2">{{ old('description2', $about_us->description2) }}
								  </textarea>
								</div>
						      </div>
						    </div>
						  </div>
						</div>

						<div class="card mb-1 border-0" >
						  <div class="row g-0">
						    <div class="col-md-4">
						    	<select class="form-select @error('favicon3') is-invalid @enderror" aria-label="Default select example" id="select3" name="favicon3" onchange="icon('select3');">
									<option value="" selected>Seleccione un icono</option>
									@foreach( $icons as $icon)
										@if (old('favicon3',$about_us->favicon3) == $icon->id)
										    <option value="{{ $icon->id }}" selected>{{$icon->icon_name}} &#x{{$icon->icon_hex_code}}</option>
										    {{ $ic3 = $icon->icon_class }}
										@else
										    <option value="{{ $icon->id }}">{{$icon->icon_name}} &#x{{$icon->icon_hex_code}}</option>
										@endif
									@endforeach
								</select>
								<div class="d-flex justify-content-center">
									<i id="icon3" class="{{$ic3}} icofont-3x mt-1"></i>
								</div>
						    </div>
						    <div class="col-md-8">
						      <div class="card-body">
						        <div class="mb-3">
								  <input type="text" name="title3" class="form-control @error('title3') is-invalid @enderror" id="title3" placeholder="Titulo 3" value="{{ old('title3', $about_us->title3) }}">
								</div>
						       <div class="mb-3">
								  <textarea class="form-control @error('description3') is-invalid @enderror" name="description3" >{{ old('description3', $about_us->description3) }}
								  </textarea>
								</div>
						      </div>
						    </div>
						  </div>
						</div>
			      	</div>
			    </div>
			    <button type="submit" class="btn btn-secondary d-grid gap-2 col-6 mx-auto">Actualizar datos</button>
		  	</div>


	</form>
	<script type="text/javascript">
	function photos(){
		const $seleccionArchivos = document.getElementById("photo");
		const archivos = $seleccionArchivos.files;
		const primerArchivo = archivos[0];
		const objectURL = URL.createObjectURL(primerArchivo);
		document.getElementById('photoAbout').src = objectURL;
	}

	function icon(id){
		var listIcon = {
			@foreach( $icons as $icon)
			{{ $icon->id }}: "{{$icon->icon_class}} icofont-3x mt-1",
			@endforeach
			{{ $icon->id }}: "{{$icon->icon_class}} icofont-3x mt-1",
			"x": "icofont-cart icofont-3x mt-1"
		}
		var cod = document.getElementById(id).value;
		if ('select1' == id ) {
			document.getElementById("icon1").className = listIcon[cod];
		}else if('select2' == id ){
			document.getElementById("icon2").className = listIcon[cod];
		}else if('select3' == id ){
			document.getElementById("icon3").className = listIcon[cod];
		}
		console.log(listIcon);
	}
</script>
</div>
@endsection()
