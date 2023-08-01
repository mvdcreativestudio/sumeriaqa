@extends('admin.layouts.master')

@section('content')

<section class="section">
    <div class="section-header d-flex justify-content-between align-items-center">
        <h1 class="mr-auto">Cobros</h1>
        <div class="card-header-action text-right">
            <a href="{{ URL::previous() }}" class="btn btn-primary">Atrás</a>
        </div>
    </div>

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
                <button type="button" class="btn btn-secondary sort-button" data-column="fecha" data-order="asc">
                    Fecha
                </button>
                <button type="button" class="btn btn-secondary sort-button" data-column="monto" data-order="asc">
                    Monto
                </button>
            </div>
        </div>
    </div>

    <div class="mt-4">
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
                    @foreach ($contabilidad as $movimiento)
                        @if ($movimiento->tipo === 'Cobro' & $movimiento->estado === 'Pago')
                            <tr class="text-center">
                                <td>{{ $movimiento->id }}</td>
                                <td>{{ $movimiento->nombre_cliente }}</td>
                                <td>
                                    <span class="text-success font-weight-bold">Ingreso</span>
                                </td>
                                <td>{{ $movimiento->concepto }}</td>
                                <td>{{ \Carbon\Carbon::parse($movimiento->fecha)->format('d/m/Y') }}</td>
                                <td>{{$settings->currency_icon}}{{ number_format($movimiento->monto, 0, ',', '.') }}</td>
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
                        @endif
                    @endforeach
                </tbody>
                
            </table>
        </div>
        
    </div>
</section>



@endsection