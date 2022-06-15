@extends('layout-dashboard')

@section('title','Cacahuarte')

@section('content')
<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4 p-4">
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
	<button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">
	  Nueva Categoria <span data-feather="plus-circle"></span>
	</button>
	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog ">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel"><span data-feather="plus-circle"></span> Agregar nueva categoría</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	      	<form method="POST" id="CagoriesForm" action="{{ route('categories.store') }}">
	      	@csrf
	      	@include('admin.Categories.__form')
			</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
	        <button type="submit" form="CagoriesForm" class="btn btn-primary">Guardar Categoria</button>
	      </div>
	    </div>
	  </div>
	</div>

</div>

<div class="content my-5">
	<table class="table">
  <thead class="table-light">
     <tr>
      <td colspan="4">
          Nombre
      </td>
      <td colspan="4">
          Descripcion
      </td>
      <td colspan="4">
          Fecha de creacion
      </td>
      <td colspan="4">
          Acciones
      </td>
    </tr>
  </thead>
  <tbody>
  	@foreach($categories as $categorie)
  	<form id="dCategorie" method="POST" action="{{ route('categories.destroy', $categorie) }}">
				@csrf @method('DELETE')
	</form>
	<form id="eCategorie" method="POST" action="{{ route('categories.destroy', $categorie) }}">
				@csrf @method('PATCH')
	</form>
    <tr>
    	<td colspan="4">
      		{{$categorie->name}}
      	</td>
      	<td colspan="4"	>
      		{{$categorie->description}}
      	</td>
      	<td colspan="4"	>
      		{{$categorie->created_at}}
      	</td>
      	<td colspan="4"	>
      		<button type="button" form="eCategorie" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal">
	  			<span data-feather="edit"></span>
			</button>
	      	<button type="submit"  form="dCategorie" class="btn btn-danger">
	  			<span data-feather="trash-2"></span>
			</button>
      	</td>
    </tr>
    	<!-- Modal -->
	<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalc" aria-hidden="true">
	  <div class="modal-dialog ">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="editModalc"><span data-feather="edit-3"></span> Editar categoría</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	      	<form method="POST" id="CagoriesForm{{$categorie->id}}" action="{{ route('categories.update',$categorie) }}">
	      	@csrf @method('PATCH')
	      	@include('admin.Categories.__form')
			</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
	        <button type="submit" form="CagoriesForm{{$categorie->id}}" class="btn btn-primary">Guardar Categoria</button>
	      </div>
	    </div>
	  </div>
	</div>
    @endforeach

  </tbody>
</table>
</div>
</main>
@endsection()
