<div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
  <div class="card-header">
    @if($tarjeta->state != 1)
      <select class="form-select icofont-dna" name="icon_id" aria-label="Default select example">
          <option value="{{$tarjeta->icon_id}}">
            {{ old('Selecciona un ícono', $tarjeta->icon_name) }} &#x{{$tarjeta->icon_hex_code}}
          </option>
          @foreach($iconos as $icono)
            <option value="{{$icono->id}}" >
              {{$icono->icon_name}} &#x{{$icono->icon_hex_code}}
            </option>
          @endforeach
      </select>
    @endif
  </div>
  <div class="card-body">
    <input type="text" class="form-control" name="title" placeholder="Título" value="{{ old('title',$tarjeta->title) }}" required>
    @error('title')
      <div class="alert-danger" role="alert"><strong>{{$message}}</strong></div>
    @enderror
    <textarea class="form-control" cols="10" rows="10" name="description" required>
      {{ old('description',$tarjeta->description) }}
    </textarea>
    @error('description')
      <div class="alert-danger" role="alert"><strong>{{$message}}</strong></div>
    @enderror
  </div>
</div>
<button  class="btn btn-primary" type="submit">{{ $btntxt }}</button>
<a  class="btn btn-success" href="{{ URL::previous() }}" role="button">
    Volver
</a>