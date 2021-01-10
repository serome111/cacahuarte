<div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
  <div class="card-header">
    <select class="form-select icofont-dan" name="icon_id" aria-label="Default select example" required>
      @if(empty($tarjeta->id))
          <option value="" selected>{{old('icon_id','Selecciona un ícono')}}</option>
          @foreach($iconos as $icono)
            <option value="{{$icono->id}}" class="{{$icono->icon_class}}" {{ old("icon_id") == $icono->id ? "selected" : " " }}>
              {{$icono->icon_name}} &#x{{$icono->icon_hex_code}}
            </option>
          @endforeach
        @else
          <option value="{{$tarjeta->icon_id}}">
            {{ old('Selecciona un ícono', $tarjeta->icon_name) }} &#x{{$tarjeta->icon_hex_code}}
          </option>
          @foreach($iconos as $icono)
            <option value="{{$icono->id}}" class="{{$icono->icon_class}}">
              {{$icono->icon_name}} &#x{{$icono->icon_hex_code}}
            </option>
          @endforeach
        @endif
    </select>
    @error('icon_id')
       <div class="alert alert-danger" role="alert">{{$message}}</div>
    @enderror
  </div>
  <div class="card-body">
    <input type="text" class="form-control" name="title" placeholder="Título" value="{{ old('title',$tarjeta->title) }}" required>
    @error('title')
      <div class="alert-danger" role="alert"><strong>{{$message}}</strong></div>
    @enderror
    <textarea class="form-control" name="description" required>
      {{ old('description',$tarjeta->description) }}
    </textarea>
    @error('description')
      <div class="alert-danger" role="alert"><strong>{{$message}}</strong></div>
    @enderror
  </div>
  <div class="card-footer text-center">
    @if(empty($tarjeta->id))
     <label for="state" class="form-label">Estado de la tarjeta</label>
     <select class="form-select" name="state" id="state" required>
        <option value="" selected>Seleccione un estado</option>
        <option value="1" class="bg-success" {{ old("state") == 1 ? "selected" : " " }}>Activo</option>
        <option value="0" class="bg-warning">Inactivo</option>
     </select>
    @error('state')
      <div class="alert-danger" role="alert"><strong>{{$message}}</strong></div>
    @enderror
    @elseif($tarjeta->state == 1)
     <label for="state" class="form-label">Cambiar estado de la tarjeta</label>
     <select class="form-select" name="state" id="state">
        <option value="1" class="bg-success">Activo</option>
        <option value="0" class="bg-warning">Inactivo</option>
     </select>
    @elseif($tarjeta->state == 0)
     <label for="state" class="form-label">Cambiar estado de la tarjeta</label>
     <select class="form-select" name="state" id="state">
        <option value="0" class="bg-warning">Inactivo</option>
        <option value="1" class="bg-success">Activo</option>
     </select>
    @endif
  </div>
</div>
<button  class="btn btn-primary" type="submit">{{ $btntxt }}</button>
<a  class="btn btn-success" href="{{ URL::previous() }}" role="button">
    Volver
</a>