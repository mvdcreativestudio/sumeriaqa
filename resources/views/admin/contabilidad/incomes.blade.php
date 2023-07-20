@extends('admin.layouts.master')

@section('content')

<section class="section">
    <div class="section-header d-flex justify-content-between align-items-center">
        <h1 class="mr-auto">Ingresos</h1>
        <div class="card-header-action text-right">
            <a href="{{ URL::previous() }}" class="btn btn-primary">Atrás</a>
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <div>
            <i class="fas fa-check-circle text-success ml-1 tooltipped" title="En fecha" style="font-size: 1.5em;"></i><a href=""> En Fecha</a>
            <i class="fas fa-exclamation-circle text-warning ml-1 tooltipped" title="Por vencer" style="font-size: 1.5em;"></i><a href=""> Por Vencer</a>
            <i class="fas fa-times-circle text-danger ml-1 tooltipped" title="Vencido" style="font-size: 1.5em;"></i><a href=""> Vencida</a> 
        </div>
        <div class="mb-3">
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
                    Creado
                </button>
                <button type="button" class="btn btn-secondary sort-button" data-column="fecha_vencimiento" data-order="asc">
                    Vencimiento
                </button>
                <button type="button" class="btn btn-secondary sort-button" data-column="monto" data-order="asc">
                    Monto
                </button>
                <button type="button" class="btn btn-secondary sort-button" data-column="estado" data-order="asc">
                    Estado
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
                            Creado
                        </th>
                        <th class="sortable" data-column="fecha_vencimiento">
                            Vencimiento
                        </th>
                        <th class="sortable" data-column="monto">
                            Monto
                        </th>
                        <th class="sortable" data-column="estado">
                            Estado
                        </th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
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
                        <td class="font-weight-bold">
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
                        </td>
                        <td>${{ number_format($movimiento->monto, 0, ',', '.') }}</td>
                        <td class="font-weight-bold">
                            @if ($movimiento->estado === 'Pago')
                            <span class="text-success">{{ $movimiento->estado }}</span>
                            @elseif ($movimiento->estado === 'Impago')
                            <span class="text-danger">{{ $movimiento->estado }}</span>
                            @else
                            {{ $movimiento->estado }}
                            @endif
                        </td>
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
                </tbody>
            </table>
        </div>
        
    </div>
</section>



@endsection