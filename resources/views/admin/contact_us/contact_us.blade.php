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
    container.innerHTML = ''; // Limpia el contenedor

    if (mensajes.length === 0) {
        const emptyMessage = document.createElement('p');
        emptyMessage.textContent = 'No se encontraron mensajes.';
        container.appendChild(emptyMessage);
    } else {
        mensajes.forEach(mensaje => {
            // Crear elementos de la tarjeta
            const card = document.createElement('div');
            card.className = 'card border-secondary mb-3';

            const cardHeader = document.createElement('div');
            cardHeader.className = 'card-header';
            cardHeader.textContent = `${mensaje.name} - ${mensaje.email}`;

            const cardBody = document.createElement('div');
            cardBody.className = 'card-body';

            const cardTitle = document.createElement('h5');
            cardTitle.className = 'card-title';
            cardTitle.textContent = `Asunto: ${mensaje.subject}`;

            const cardText = document.createElement('p');
            cardText.className = 'card-text';
            cardText.textContent = mensaje.message;

            const cardFooter = document.createElement('div');
            cardFooter.className = 'card-footer text-muted';
            cardFooter.textContent = mensaje.created_at;

            // Crear botón que dispara el modal
            const deleteButton = document.createElement('button');
            deleteButton.className = 'btn btn-danger';
            deleteButton.textContent = 'Eliminar';
            deleteButton.setAttribute('data-bs-toggle', 'modal');
            deleteButton.setAttribute('data-bs-target', `#modalEliminar${mensaje.id}`);

            // Construcción del modal
            const modal = document.createElement('div');
            modal.className = 'modal fade';
            modal.id = `modalEliminar${mensaje.id}`;
            modal.setAttribute('tabindex', '-1');
            modal.setAttribute('aria-labelledby', `modalLabelEliminar${mensaje.id}`);
            modal.setAttribute('aria-hidden', 'true');
            modal.innerHTML = `
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabelEliminar${mensaje.id}">Eliminando...</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ¿Realmente desea eliminar este mensaje? Una vez hecho no se podrá recuperar.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" onclick="eliminarMensaje(${mensaje.id})">Eliminar</button>
                        </div>
                    </div>
                </div>
            `;

            // Añadir elementos a la tarjeta
            cardBody.appendChild(cardTitle);
            cardBody.appendChild(cardText);
            cardBody.appendChild(deleteButton);
            card.appendChild(cardHeader);
            card.appendChild(cardBody);
            card.appendChild(cardFooter);

            // Añadir la tarjeta y el modal al contenedor
            container.appendChild(card);
            container.appendChild(modal);
        });
    }
}

function eliminarMensaje(id) {
    // Lógica para eliminar el mensaje
    // Puede ser una solicitud fetch a tu servidor para eliminar el mensaje
    console.log('Eliminar mensaje con id:', id);
    // Recuerda actualizar la interfaz de usuario después de eliminar
}



</script>
@endsection()
