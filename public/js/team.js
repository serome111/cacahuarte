let avatar = document.querySelector('#avatar')
function fotoTeam(){
	let foto = document.querySelector('#imagen');
	let archivos = foto.files[0];
	let nombreImagen = URL.createObjectURL(archivos);
	avatar.setAttribute('src',nombreImagen);
}