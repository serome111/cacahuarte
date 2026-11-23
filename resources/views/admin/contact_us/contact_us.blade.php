@extends('layout-dashboard')

@section('title','Cacahuarte')

@section('content')
<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">
		<p class="display-4 text-center" id="mensaje-cantidad">Mensajes de nuestros clientes: {{ $cantidad }}</p>

        <form action="{{ route('contact_us.index') }}" method="GET" class="mx-auto col-sm-5 pb-4">
            <label for="filter-email" class="form-label">Buscar mensajes</label>
            <input type="search" class="form-control" id="filter-email" name="text" maxlength="255" value="{{ request('text') }}">
            <button type="submit" class="btn btn-secondary mt-2">Filtrar</button>
            <a href="{{ route('contact_us.index') }}" class="btn btn-link mt-2">Limpiar</a>
        </form>
        @if ($contact->isNotEmpty())
            <button type="button" class="btn btn-danger mb-4" data-bs-toggle="modal" data-bs-target="#modalEliminarFiltrados">
                Eliminar {{ request()->filled('text') ? 'mensajes filtrados' : 'mensajes de esta página' }}
            </button>
        @endif
		<div class="row" id="mensajes-container">
			@if($contact->isEmpty())
				<div>
					<p class="text-muted h3">No hay mensajes para mostrar</p>
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
						  <button class="btn btn-primary dropdown-toggle" type="button" id="message-action-{{ $mensaje->id }}" data-bs-toggle="dropdown" aria-expanded="false">
						    Acción
						  </button>
						  <ul class="dropdown-menu" aria-labelledby="message-action-{{ $mensaje->id }}">
						    <li>
							<a type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#message-delete-{{ $mensaje->id }}">
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
				<div class="modal fade" id="message-delete-{{ $mensaje->id }}" tabindex="-1" aria-labelledby="message-confirm-{{ $mensaje->id }}" aria-hidden="true">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="message-confirm-{{ $mensaje->id }}">Eliminar mensaje</h5>
				        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				      </div>
				      <div class="modal-body">
				        <p>¿Realmente desea eliminar este mensaje? Una vez hecho no se podrá recuperar.</p>
				      </div>
				      <div class="modal-footer">
				        <form  class="dropdown-item" method="POST" action="{{ route('contact_us.destroy', $mensaje->id) }}">	
					@csrf @method('DELETE')
					        <a rel="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</a>
					<button type="submit" class="btn btn-primary">Eliminar</button>
						</form>
				      </div>
				    </div>
				  </div>
				</div>
			   @endforeach
			@endif
		</div>
        {{ $contact->links() }}

		<div class="modal fade" id="modalEliminarFiltrados" tabindex="-1" aria-labelledby="modalLabelEliminarFiltrados" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modalLabelEliminarFiltrados">Eliminar {{ request()->filled('text') ? 'mensajes filtrados' : 'mensajes de esta página' }}</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<p>¿Realmente desea eliminar los {{ request()->filled('text') ? $contact->total() : $contact->count() }} mensajes y bloquear a sus remitentes? Una vez hecho no se podrán recuperar.</p>
					</div>
					<p class="text-danger px-3" role="alert" id="bulk-delete-error" hidden>No se pudieron eliminar los mensajes.</p>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
						<button type="button" class="btn btn-primary" id="confirm-bulk-delete">Eliminar</button>
					</div>
				</div>
			</div>
		</div>
</main>

<script>
    const confirmBulkDelete = document.getElementById('confirm-bulk-delete');

    confirmBulkDelete.addEventListener('click', async () => {
        const errorMessage = document.getElementById('bulk-delete-error');
        confirmBulkDelete.disabled = true;
        errorMessage.hidden = true;

        try {
            const response = await fetch(@json(route('contact_us.bulk_destroy')), {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': @json(csrf_token())
                },
                body: JSON.stringify(@json(request()->filled('text')
                    ? ['text' => request('text')]
                    : ['ids' => $contact->getCollection()->modelKeys()]))
            });
            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.errors?.text?.[0] ?? 'No se pudieron eliminar los mensajes.');
            }

            const destination = new URL(window.location.href);
            destination.searchParams.delete('page');
            window.location.assign(destination);
        } catch (error) {
            errorMessage.textContent = error.message;
            errorMessage.hidden = false;
            confirmBulkDelete.disabled = false;
        }
    });
</script>
@endsection
