document.addEventListener("DOMContentLoaded", cargarDepartamentos());
// let dapartamentosRepetidos = [];
// API
async function obtenerDatosAPI() {
	  const url = `https://raw.githubusercontent.com/marcovega/colombia-json/master/colombia.min.json`;

	  // fetch a la api
	  const urlObtenerDatos = await fetch(url);

	  // respuesta en json
	  const datos = await urlObtenerDatos.json();

	  return {
		   datos
	  }
 }
 

// Departamentos
function cargarDepartamentos(){
	const select = document.querySelector('#departamento');

	obtenerDatosAPI()
		.then(datos => {
			for( const [key, value] of Object.entries(datos.datos) ){
				// console.log(value); 
				const opcion = document.createElement('option');
				opcion.value = value.departamento;
				opcion.appendChild(document.createTextNode(value.departamento))
				// llenamos el select
				select.appendChild(opcion);
			}
		})
}

// Municipios		
function capital(){
	//se lee el departamento seleccionado
	const departamentoSelect = document.querySelector('#departamento');
	const departamentoSeleccionado = departamentoSelect.options[departamentoSelect.selectedIndex].value;
	/* console.log(departamentoSeleccionado) */
	const select = document.querySelector('#ciudad');
	// se selecciona el select
	if(select.childNodes.length > 0){
		select.innerHTML = "";
	}
	
	obtenerDatosAPI()
		.then(datos => {
			// para recorrer un objeto
			for( const [key, value] of Object.entries(datos.datos)){
				// si el departamento se encuentra
				if(value.departamento == departamentoSeleccionado){
					// se recorre el array de cuidades
					value.ciudades.forEach(dato => {
					// añadir el municipio como opciones
					const opcion = document.createElement('option');
					opcion.value = dato;
					opcion.appendChild(document.createTextNode(dato))
					// llenamos el select
					select.appendChild(opcion);
					})	
				}
			}
		})
}

// foto cliente
function photoBanner(){
		const $seleccionArchivos = document.querySelector("#photo");
		const archivos = $seleccionArchivos.files;
		const primerArchivo = archivos[0];
		const objectURL = URL.createObjectURL(primerArchivo);
		document.getElementById('bannerDiv').style.backgroundImage = "url('"+objectURL+"')";

}