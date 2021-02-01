document.addEventListener("DOMContentLoaded", cargarDepartamentos());
let dapartamentosRepetidos = [];
// API
async function obtenerDatosAPI() {
	  const url = `https://tupale.co//milfs/api.php?id=819&tipo=simple`;

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
	obtenerDatosAPI()
		.then(datos => {
			for( const [key, value] of Object.entries(datos.datos) ){
				/* console.log(value.id); */
				// se guardan los datos en el array como vienen 
				dapartamentosRepetidos.push(value.Departamento)
			}
			// con new Set se quitan los valores repetidos en el array
			let datosUnicos = [... new Set(dapartamentosRepetidos)]
			/* console.log(datosUnicos) */
			// se selecciona el select
			const select = document.querySelector('#departamento');
			datosUnicos.forEach(dato => {
				if(dato != undefined){
					// añadir el departamento opciones
					const opcion = document.createElement('option');
					opcion.value = dato;
					opcion.appendChild(document.createTextNode(dato))
					// llenamos el select
					select.appendChild(opcion);
				}
			})
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
	if(select.childNodes.length > 2){
		select.innerHTML = "";
	}
	
	obtenerDatosAPI()
		.then(datos => {
			// para recorrer un objeto
			for( const [key, value] of Object.entries(datos.datos)){
				// añadir el municipio como opciones
				const opcion = document.createElement('option');
				if(value.Departamento == departamentoSeleccionado){
					opcion.value = value.MUNICIPIO;
					opcion.appendChild(document.createTextNode(value.MUNICIPIO))
					// llenamos el select
					select.appendChild(opcion);
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