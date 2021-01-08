<div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
  <div class="card-header">
    <select class="form-select" name="nombreIcono" aria-label="Default select example" >
      <option selected>Selecciona un ícono</option>
      <option value="1" class="icofont-dan">One &#xec17;</option>
      <option value="2" class="icofont-pulse">Two &#xec31;</option>
      <option value="3" class="icofont-surgeon">Three &#xec36;</option>
    </select>
  </div>
  <div class="card-body">
    <input type="text" class="form-control" name="tituloCard" placeholder="Título">
    <textarea class="form-control" name="contenidoCard" placeholder="Descripción"></textarea>
  </div>
</div>

<!-- Example single danger button -->
<div class="btn-group">
  <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
   Action
  </button>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="#">editar</a></li>
    <li><a class="dropdown-item" href="#">eliminar</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="#">Activar</a></li>
  </ul>
</div>
<button  class="btn btn-primary" type="submit">{{ $btntxt }}</button>