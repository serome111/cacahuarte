<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Titulo</label>
  <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="titulo">
</div>
<div class="mb-3">@lang('Descripcion')</label>
  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
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