@extends('layout-dashboard')

@section('title','Cacahuarte')

@section('content')
<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">
		<p class="display-4 text-center">Mensajes de nuestros clientes: {{ $cantidad }}</p>

		<div class="mx-auto col-sm-5 pb-4">
		  <input type="text" class="form-control" id="filter-email" placeholder="Filtrar mensaje..." onkeyup="filter(this);">
		</div>

		<div class="row" id="mensajes-container">
			@if($contact->isEmpty())
				<div>
					<p class="text-muted h3">°No hay mensajes para mostrar</p>
				</div>
			@else
			  @foreach($contact as $mensaje)
				<div class="col-sm-6 mb-5 mx-auto">
					<div class="card border-secondary">
					  <div class="card-header">
					    {{ $mensaje->name}} - {{ $mensaje->email }}
					  </div>
					  <div class="card-body">
					    <h5 class="card-title">Asunto: {{ $mensaje->subject }}</h5>
					    <p class="card-text">{{ $mensaje->message }}</p>
					    <div class="dropdown">
						  <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
						    Acción
						  </button>
						  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
						    <li>
						    	<a type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#exampleModal1">
			    					<i class="icofont-garbage"></i> Eliminar
			    				</a>
			    			</li>
						  </ul>
						</div>
					  </div>
					  <div class="card-footer text-muted">
					   	{{ $mensaje->created_at }}
					  </div>
					</div>
				</div>
				<!-- Modal -->
				<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title">Eliminando...</h5>
				        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				      </div>
				      <div class="modal-body">
				        <p>¿Realmente desea elimiar este mensaje? Una vez hecho no se podrá recuperar.</p>
				      </div>
				      <div class="modal-footer">
				        <form  class="dropdown-item" method="POST" action="{{ route('contact_us.destroy', $mensaje->id) }}">	
				        	@csrf @method('DELETE')
					        <a rel="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</a>
				        	<button type="submit" class="btn btn-primary">Eliminar</button>
						</form>
				      </div>
				    </div>
				  </div>
				</div>
			   @endforeach
			@endif
		</div>
</main>

<script type="text/javascript">
	function filter(value){
		window.CSRF_TOKEN = '{{ csrf_token() }}';
		if(value){
			filter_mail = document.getElementById("filter-email").value;
			if (filter_mail.trim() === '') {
        console.log('Por favor, introduce un texto.');
        return;
    	}
			var datos = new FormData();
			datos.append('text', filter_mail);
			fetch("{{ route('filter-message') }}",{
				headers: {
       			'X-CSRF-TOKEN': window.CSRF_TOKEN
    			},
				method: 'POST',
				body: datos
			 })
			.then( res => res.json())
			.then( data => {
				console.log(data)
				actualizarMensajes(data);
			}).catch(error =>{
				console.log(error);	
			  console.log('Se ha encontrado un error en el archivo o web que se hace la peticion');
			})

		}

	}

	function actualizarMensajes(mensajes) {
    const container = document.getElementById('mensajes-container');
    container.innerHTML = '';
    if (mensajes[0] === "error") {
      container.innerHTML = '<p>No se encontraron mensajes.</p>';
      return
    }
    mensajes.forEach(mensaje => {
      const mensajeDiv = document.createElement('div');
      mensajeDiv.classList.add('col-sm-6', 'mb-5', 'mx-auto');
      mensajeDiv.innerHTML = `
          <div class="card border-secondary">
              <div class="card-header">
                  ${mensaje.name} - ${mensaje.email}
              </div>
              <div class="card-body">
                  <h5 class="card-title">Asunto: ${mensaje.subject}</h5>
                  <p class="card-text">${mensaje.message}</p>
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminar${mensaje.id}">
                      Eliminar
                  </button>
              </div>
              <div class="card-footer text-muted">
                  ${mensaje.created_at}
              </div>
          </div>

          <!-- Modal -->
          <div class="modal fade" id="modalEliminar${mensaje.id}" tabindex="-1" aria-labelledby="modalLabelEliminar${mensaje.id}" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title">Eliminando...</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                          <p>¿Realmente desea eliminar este mensaje? Una vez hecho no se podrá recuperar.</p>
                      </div>
                      <div class="modal-footer">
                        <form method="POST" action="{{ route('contact_us.destroy', $mensaje->id) }}">
                            @csrf @method('DELETE')
                            <a rel="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</a>
                            <button type="submit" class="btn btn-primary">Eliminar</button>
                        </form>
                      </div>
                  </div>
              </div>
          </div>
      `;
      container.appendChild(mensajeDiv);
    });
}


</script>
@endsection()
