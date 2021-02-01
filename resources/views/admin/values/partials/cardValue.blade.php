<div class="container justify-content-md-center">
	<div class="col-sm-6 mb-5 mx-auto">
		<div class="card shadow" style="height: 200px; background:transparent url({{ $val = empty($photo) ? 'img/values-2.jpg' : $photo}}) no-repeat center center /cover" id="valueDiv">
		 	<div class="card-body">
				<div class="card border-0 bg-transparent">
				    <br><br><br>
				</div>
				<div class="card text-center" style="opacity: .8;">
			        <h5 class="card-title" id="valueTitle"><a href="">{{$title}}</a></h5>
			        <p class="card-text" id="valueDescription">
			        	{{$description}}
			    	</p>
		  		</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function titleValue(){
	  var name = document.getElementById("title").value;
	  document.getElementById("valueTitle").innerHTML = name;
	}
	function descriptionValue(){
		var name;
		name = document.getElementById("description").value;
		document.getElementById("valueDescription").innerHTML = name;
	}
	function pictureValue(){
		const $seleccionArchivos = document.querySelector("#picture");
		const archivos = $seleccionArchivos.files;
		const primerArchivo = archivos[0];
		const objectURL = URL.createObjectURL(primerArchivo);
		document.getElementById('valueDiv').style.backgroundImage = "url('"+objectURL+"')";
		//doc
	//https://parzibyte.me/blog/2019/05/20/previsualizar-imagen-input-file-javascript-html/
	}
</script>