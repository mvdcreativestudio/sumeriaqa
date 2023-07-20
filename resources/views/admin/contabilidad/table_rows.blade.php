@foreach ($contabilidad as $movimiento)
    <tr class="text-center">
        <td>{{ $movimiento->id }}</td>
        <td>{{ $movimiento->nombre_cliente }}</td>
        <td>
            @if ($movimiento->tipo === 'Cobro')
                <span class="text-success font-weight-bold">Ingreso</span>
            @else
                <span class="text-danger font-weight-bold">Egreso</span>
            @endif
        </td>
        <td>{{ $movimiento->concepto }}</td>
        <td>{{ \Carbon\Carbon::parse($movimiento->fecha)->format('d/m/Y') }}</td>
        <td>${{ number_format($movimiento->monto, 0, ',', '.') }}</td>
        <td class="text-right">
            <a href="{{ route('contabilidad.ver', $movimiento->id) }}" class="btn btn-primary btn-action btn-detail" data-toggle="tooltip" title="Ver">
                <i class="fas fa-eye"></i>
            </a>
            <a href="{{ route('contabilidad.editar', $movimiento->id) }}" class="btn btn-primary btn-action btn-edit" data-id="{{ $movimiento->id }}" title="Editar">
                <i class="fas fa-pencil-alt"></i>
            </a>
            <form action="{{ route('contabilidad.eliminar', $movimiento->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-action btn-delete" data-toggle="tooltip" title="Eliminar" onclick="return confirm('¿Estás seguro de que quieres eliminar este movimiento?')">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </td>
    </tr>
@endforeach