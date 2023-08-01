@extends('admin.layouts.master')

@section('content')

<section class="section">
    <div>
        <div class="section-header d-flex justify-content-between align-items-center">
            <h1 class="mr-auto">Todas las órdenes</h1>
            <div class="card-header-action text-right">
                <a href="{{ route('admin.contabilidad.crear-orden') }}" class="btn btn-primary">Crear factura</a>
                {{-- <a href="{{ URL::previous() }}" class="btn btn-primary">Atrás</a> --}}
            </div>
        </div>

        <div class="mt-4">
            <div class="d-flex justify-content-between">
                <div class="mb-3">
                    <a href="">Ordenar por:</a>
                    <label for="selectSort"></label>
                    <div class="btn-group" role="group" aria-label="Ordenar por">
                        <button type="button" class="btn btn-secondary sort-button" data-column="id" data-order="asc">
                            Id
                        </button>
                        <button type="button" class="btn btn-secondary sort-button" data-column="nombre_cliente" data-order="asc">
                            Nombre del Cliente
                        </button>
                        <button type="button" class="btn btn-secondary sort-button" data-column="tipo" data-order="asc">
                            Tipo
                        </button>
                        <button type="button" class="btn btn-secondary sort-button" data-column="fecha_vencimiento" data-order="asc">
                            Vencimiento
                        </button>
                        <button type="button" class="btn btn-secondary sort-button" data-column="estado" data-order="asc">
                            Estado
                        </button>
                        <button type="button" class="btn btn-secondary sort-button" data-column="monto" data-order="asc">
                            Monto
                        </button>
                    </div>
                </div>
            </div>
            


            <div class="mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Buscar orden...">
            </div>

                
            <div class="table-responsive">
                <table id="contabilidadTable" class="table table-striped table">
                    <thead class="thead-dark">
                        <tr class="tr-light text-center">
                            <th class="sortable" data-column="id">
                                Id
                            </th>
                            <th class="sortable" data-column="nombre_cliente">
                                Nombre del Cliente
                            </th>
                            <th class="sortable" data-column="tipo">
                                Tipo
                            </th>
                            <th>
                                Descripción
                            </th>
                            <th class="sortable" data-column="fecha">
                                Fecha de vencimiento
                            </th>
                            <th class="sortable" data-column="estado">
                                Estado
                            </th>
                            <th class="sortable" data-column="monto">
                                Monto
                            </th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
            
                    <tbody>
                        @foreach ($contabilidad as $movimiento)
                        @if ($movimiento->estado === 'Impago' )
                            <tr class="text-center">
                                <td>{{ $movimiento->id }}</td>
                                <td>
                                    @if ($movimiento->usuario_id === null)
                                        {{ $movimiento->nombre_cliente }} (Invitado)
                                    @else
                                        {{ $movimiento->nombre_cliente }}
                                    @endif
                                </td>
                                <td>
                                    @if ($movimiento->tipo === 'Cobro')
                                    <span class="text-success font-weight-bold">Ingreso</span>
                                    @else
                                    <span class="text-danger font-weight-bold">Egreso</span>
                                    @endif
                                </td>
                                <td>{{ $movimiento->concepto }}</td>
                                <td>{{ \Carbon\Carbon::parse($movimiento->fecha_vencimiento)->format('d/m/Y') }}</td>
                                {{-- <td class="font-weight-bold">
                                    <span>
                                        {{ \Carbon\Carbon::parse($movimiento->fecha_vencimiento)->format('d/m/Y') }}
                                        @if ($movimiento->estado === 'Impago')
                                        @if ($movimiento->estado_vencimiento === 'Vigente')
                                        <i class="fas fa-check-circle text-success ml-1 tooltipped" title="En fecha" style="font-size: 1.2em;"></i>
                                        @elseif ($movimiento->estado_vencimiento === 'Por Vencer')
                                        <i class="fas fa-exclamation-circle text-warning ml-1 tooltipped" title="Por vencer" style="font-size: 1.2em;"></i>
                                        @elseif ($movimiento->estado_vencimiento === 'Vencida')
                                        <i class="fas fa-times-circle text-danger ml-1 tooltipped" title="Vencido" style="font-size: 1.2em;"></i>
                                        @endif
                                        @endif
                                    </span>
                                </td> --}}
                                <td class="font-weight-bold">
                                    @if ($movimiento->estado_vencimiento === 'Vigente')
                                    <span class="text-success">{{ $movimiento->estado_vencimiento }}</span>
                                    @elseif ($movimiento->estado_vencimiento === 'Por Vencer')
                                    <span class="text-warning">{{ $movimiento->estado_vencimiento }}</span>
                                    @else
                                    <span class="text-danger">{{ $movimiento->estado_vencimiento }}</span>
                                    @endif
                                </td>
                                <td>{{$settings->currency_icon}}{{ number_format($movimiento->monto, 0, ',', '.') }}</td>

                                <td class="text-right">
                                    <form action="{{ route('contabilidad.marcar-como-pago', $movimiento->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success btn-action btn-marcar-pago" data-toggle="tooltip" title="Marcar como pago" onclick="return confirm('¿Estás seguro de que quieres marcar esta factura como pago?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('contabilidad.eliminar', $movimiento->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-action btn-delete" data-toggle="tooltip" title="Eliminar" onclick="return confirm('¿Estás seguro de que quieres eliminar esta factura?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>

                                {{-- ACCIONES VIEJAS --}}

                                {{-- <td class="text-right">
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
                                </td> --}}
                            </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            
        </div>
        
    </div>
</section>

    
@endsection


@push('scripts')
  
    <script>
        // Boton formulario agregar
        var toggleFormBtn = document.getElementById('toggleFormBtn');
        var movimientoForm = document.getElementById('movimientoForm');
        var tipoInput = document.querySelector('input[name="tipo"]');

        toggleFormBtn.addEventListener('click', function() {
            if (movimientoForm.style.display === 'block') {
                movimientoForm.style.display = 'none';
            } else {
                movimientoForm.style.display = 'block';
                tipoInput.value = 'movimiento';
            }
        });
    </script>

<script>
    $(document).ready(function() {
        // Capturar el evento de cambio en el campo de búsqueda
        $('#searchInput').on('keyup', function() {
            var searchText = $(this).val().toLowerCase();
            searchText = normalizeText(searchText); // Normalizar el texto de búsqueda

            // Filtrar las filas de la tabla según el texto de búsqueda
            $("#contabilidadTable tbody tr").filter(function() {
                var rowText = $(this).text().toLowerCase();
                rowText = normalizeText(rowText); // Normalizar el texto de la fila
                $(this).toggle(rowText.indexOf(searchText) > -1);
            });
        });

        // Función para normalizar un texto removiendo los tildes
        function normalizeText(text) {
            return text.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
        }
    });
</script>

@endpush