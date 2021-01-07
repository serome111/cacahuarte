<div class="card shadow col-6 mx-auto" style="height: 200px; background:transparent url(
	{{$action = empty($photo) ? '/images/hero-bg.jpg?ac74f1c3aff13b2b4d2e539f276dece2' : $photo
}}) no-repeat center center /cover;" id="bannerDiv">
{{-- /images/hero-bg.jpg?ac74f1c3aff13b2b4d2e539f276dece2 --}}
 	<div class="card-body position-absolute top-50 translate-middle-y">
		<h5 class="card-title" id="bannerTitle" style="color: #fff;">
		{{$action = empty($title) ? 'Bienvenido a Cacahuarte' : $title}}
		</h5>
    	<p class="card-text" id="bannerDescription" style="color: #fff;">
    	{{$action = empty($description) ? 'Somos una empresa productora de cacao 100% natural del municipio de elias Huila Colombia' : $description}}</p>
  	</div>
</div>

<script type="text/javascript">
	function titleBanner(){
	  var name;
	  name = document.getElementById("title").value;
	  document.getElementById("bannerTitle").innerHTML = name;
	}
	function descriptionBanner(){
		var name;
		name = document.getElementById("description").value;
		document.getElementById("bannerDescription").innerHTML = name;
	}
	function photoBanner(){
		const $seleccionArchivos = document.querySelector("#photo");
		const archivos = $seleccionArchivos.files;
		const primerArchivo = archivos[0];
		const objectURL = URL.createObjectURL(primerArchivo);
		document.getElementById('bannerDiv').style.backgroundImage = "url('"+objectURL+"')";
		//doc
	//https://parzibyte.me/blog/2019/05/20/previsualizar-imagen-input-file-javascript-html/
	}
</script>