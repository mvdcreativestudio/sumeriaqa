@extends('admin.layouts.master')

@section('content')

<section class="section">
    <div>
        <div class="section-header d-flex justify-content-between align-items-center">
            <h1 class="mr-auto">Todos los movimientos</h1>
            <div class="card-header-action text-right">
                <a href="{{ URL::previous() }}" class="btn btn-primary">Atrás</a>
            </div>
        </div>

        <div class="mt-5 mb-">
            <div class="mb-3 text-right">
                <button id="toggleFormBtn" class="btn btn-primary" value="movimiento">
                    Agregar Movimiento
                </button>
            </div>

            <form id="movimientoForm" action="{{ route('contabilidad.agregar', ['accion' => 'movimiento']) }}" method="POST" style="display: none;">
                @csrf
                <div class="mb-3">
                    <label for="usuario_id" class="form-label">Nombre del Cliente:</label>
                    <select name="usuario_id" id="usuario_id" class="form-select form-control w-100" required>
                        @foreach($usuarios as $usuarioId => $nombreCompleto)
                            <option value="{{ $usuarioId }}">{{ $nombreCompleto }}</option>
                        @endforeach
                    </select>
                </div>
            
                <div class="mb-3">
                    <label for="concepto" class="form-label">Concepto de Movimiento:</label>
                    <input type="text" class="form-control" name="concepto" required>
                </div>
                <div class="mb-3">
                    <label for="monto" class="form-label">Monto:</label>
                    <input type="number" class="form-control" name="monto" required>
                </div>
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo:</label>
                    <select name="tipo" class="form-select form-control w-100" required>
                        <option value="Cobro">Cobro</option>
                        <option value="Pago">Pago</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="fecha_vencimiento" class="form-label">Vencimiento:</label>
                    <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="estado">Estado:</label>
                    <select name="estado" class="form-select form-control w-100" required>
                        <option value="Pago">Pago</option>
                        <option value="Impago">Impago</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Agregar</button>
            </form>
            
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
                        <button type="button" class="btn btn-secondary sort-button" data-column="fecha" data-order="asc">
                            Fecha
                        </button>
                        <button type="button" class="btn btn-secondary sort-button" data-column="monto" data-order="asc">
                            Monto
                        </button>
                    </div>
                </div>
            </div>
            


            <div class="mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Buscar movimiento...">
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
                                Fecha
                            </th>
                            {{-- <th class="sortable" data-column="fecha_vencimiento">
                                Vencimiento
                            </th> --}}
                            <th class="sortable" data-column="monto">
                                Monto
                            </th>
                            {{-- <th class="sortable" data-column="estado">
                                Estado
                            </th> --}}
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
            
                    <tbody>
                        @foreach ($contabilidad->sortBy('fecha_de_pago') as $movimiento)
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
                            <td>{{ \Carbon\Carbon::parse($movimiento->fecha_de_pago)->format('d/m/Y') }}</td>
                            <td>{{$settings->currency_icon}}{{ number_format($movimiento->monto, 0, ',', '.') }}</td>
                            <td class="text-right">
                                <a href="{{ route('contabilidad.ver', $movimiento->id) }}" class="btn btn-primary btn-action btn-detail" data-toggle="tooltip" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('contabilidad.editar', $movimiento->id) }}" class="btn btn-primary btn-action btn-edit" data-id="{{ $movimiento->id }}" title="Editar">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('contabilidad.eliminar', $movimiento->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este movimiento?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-action btn-delete" data-toggle="tooltip" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
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