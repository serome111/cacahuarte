@extends('layout-dashboard')

@section('title','Cacahuarte')

@section('content')

<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">
<div class="card mb-3">
    <form method="POST" action="{{ route('about_as.update', $about_us[0]) }}" enctype="multipart/form-data">
    	@foreach( $about_us as $aboutUs )
		    <div class="row g-0">

			    <div class="col-md-4">
			       	<img src="{{ $aboutUs->photo }}" id="photoAbout" alt="banner de video" width="380" height="560">
			        <div class="mb-3 mb-3 col-md-5">
					  <label for="photo" class="form-label">Imagen principal</label>
					  <input class="form-control @error('photo') is-invalid @enderror" type="file" photo="photo" name="photo" id="photo" value="{{ old('photo', $aboutUs->photo) }}" onchange="photo();">
					</div>
					<div class="mb-3">
					  <label for="exampleFormControlInput1" class="form-label">Link</label>
					  <input type="text" class="form-control" id="link" placeholder="link de youtube"value="{{ old('link', $aboutUs->link) }}">
					</div>
			    </div>

			    <div class="col-md-8">
			      	<div class="card-body">
						<div class="mb-3">
						  <label for="exampleFormControlInput1" class="form-label">Titulo principal</label>
						  <input type="text" name="title" class="form-control" id="title" placeholder="Equipo de ...." value="{{ old('title', $aboutUs->title) }}">
						</div>
				        <div class="mb-3">
						  <label for="exampleFormControlInput1" class="form-label">Descripcion</label>
						  <textarea class="form-control" name="description">{{ old('description', $aboutUs->description) }}</textarea>
						</div>

				        <div class="card mb-1 border-0" >
						  <div class="row g-0">
						    <div class="col-md-4">
						      	<select class="form-select" aria-label="Default select example" id="select1" onchange="icon('select1');" name="icon1">
								  <option value="" selected>Seleccione un icono</option>
								  @foreach( $icons as $icon)
									<option value="{{ $icon->id }}" {{ old("icon_id") == $icon->id ? "selected" : " " }}>
										{{$icon->icon_name}} &#x{{$icon->icon_hex_code}}
									</option>
								  @endforeach
								</select>
								<div class="d-flex justify-content-center">
									<i id="icon1" class="icofont-cart icofont-3x mt-1"></i>
								</div>
						    </div>
						    <div class="col-md-8">
						      <div class="card-body">
						        <div class="mb-3">
									<input type="text" class="form-control" id="title1" placeholder="Titulo 1" value="{{ old('title1', $aboutUs->title1) }}">
								</div>
						       <div class="mb-3">
								  <textarea class="form-control">{{ old('description1', $aboutUs->description1) }}
								  </textarea>
								</div>
						      </div>
						    </div>
						  </div>
						</div>

						<div class="card mb-1 border-0" >
						  <div class="row g-0">
						    <div class="col-md-4">
						      	<select class="form-select" aria-label="Default select example"  id="select2" onchange="icon('select2');">
								  <option value="" selected>Seleccione un icono</option>
								  @foreach( $icons as $icon)
									<option value="{{ $icon->id }}">
										{{ $icon->icon_name }}
									</option>
								  @endforeach

								</select>
								<div class="d-flex justify-content-center">
									<i id="icon2" class="icofont-cart icofont-3x mt-1"></i>
								</div>
						    </div>
						    <div class="col-md-8">
						      <div class="card-body">
						        <div class="mb-3">
								  <input type="text" class="form-control" id="title1" placeholder="Titulo 1" value="{{ old('title1', $aboutUs->title2) }}">
								</div>
						       <div class="mb-3">
								  <textarea class="form-control">{{ old('description1', $aboutUs->description2) }}
								  </textarea>
								</div>
						      </div>
						    </div>
						  </div>
						</div>

						<div class="card mb-1 border-0" >
						  <div class="row g-0">
						    <div class="col-md-4">
						      <select class="form-select" aria-label="Default select example" id="select3" onchange="icon('select3');">
								  <option value="" selected>Seleccione un icono</option>
								  @foreach( $icons as $icon)
									<option value="{{ $icon->id }}"  class="{{$icon->icon_class}}" {{ old("icon_id") == $icon->id ? "selected" : " " }}>
										{{$icon->icon_name}} &#x{{$icon->icon_hex_code}}
									</option>
								  @endforeach
								</select>
								<div class="d-flex justify-content-center">
									<i id="icon3" class="icofont-cart icofont-3x mt-1"></i>
								</div>
						    </div>
						    <div class="col-md-8">
						      <div class="card-body">
						        <div class="mb-3">
								  <input type="text" class="form-control" id="title1" placeholder="Titulo 1" value="{{ old('title1', $aboutUs->title3) }}">
								</div>
						       <div class="mb-3">
								  <textarea class="form-control">{{ old('description1', $aboutUs->description3) }}
								  </textarea>
								</div>
						      </div>
						    </div>
						  </div>
						</div>
			      	</div>
			      	<button type="button" type="submit" class="btn btn-secondary d-grid gap-2 col-6 mx-auto">Actualizar datos</button>
			    </div>

		  	</div>
	  	@endforeach

	</form>
	<script type="text/javascript">
	function photo(){
		const $seleccionArchivos = document.querySelector("#photo");
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

		// const objectURL = URL.createObjectURL(primerArchivo);
		// document.getElementById('photoAbout').src = objectURL;
	}
</script>
</div>
@endsection()
