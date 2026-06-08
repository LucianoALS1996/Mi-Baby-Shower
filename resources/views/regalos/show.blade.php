@foreach ($babyshower->regalos as $regalo)

    <hr>

    <h3>{{ $regalo->nombre }}</h3>

    <form method="POST"
          action="{{ route('babyshowers.regalos.update', [$babyshower->id_babyshower, $regalo->id_regalo]) }}">

        @csrf
        @method('PUT')

        <label>Nombre</label><br>
        <input type="text" name="nombre" value="{{ $regalo->nombre }}" required>

        <br><br>

        <label>Descripción</label><br>
        <textarea name="descripcion">{{ $regalo->descripcion }}</textarea>

        <br><br>

        <label>Cantidad sugerida</label><br>
        <input type="number"
               name="cantidad_sugerida"
               value="{{ $regalo->cantidad_sugerida }}"
               min="1"
               required>

        <br><br>

        <p>
            <strong>Reservados:</strong>
            {{ $regalo->cantidad_reservada }}
        </p>

        <p>
            <strong>Disponibles:</strong>
            {{ $regalo->cantidad_sugerida - $regalo->cantidad_reservada }}
        </p>

        <p>
            <strong>Estado:</strong>
            {{ $regalo->estado }}
        </p>

        <button type="submit">
            Guardar cambios
        </button>
    </form>

    <br>

    <form method="POST"
          action="{{ route('babyshowers.regalos.destroy', [$babyshower->id_babyshower, $regalo->id_regalo]) }}"
          style="display:inline;">

        @csrf
        @method('DELETE')

        @if ($regalo->estado === 'activo')
            <button type="submit">Deshabilitar regalo</button>
        @else
            <button type="submit">Habilitar regalo</button>
        @endif
    </form>

@endforeach
