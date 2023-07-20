@extends('admin.layouts.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Editar Movimiento</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.contabilidad.actualizar', $movimiento->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nombre_cliente">Nombre Cliente</label>
                    <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" value="{{ $movimiento->nombre_cliente }}">
                </div>
                <div class="form-group">
                    <label for="concepto">Concepto</label>
                    <input type="text" class="form-control" id="concepto" name="concepto" value="{{ $movimiento->concepto }}">
                </div>
                <div class="form-group">
                    <label for="monto">Monto</label>
                    <input type="text" class="form-control" id="monto" name="monto" value="{{ $movimiento->monto }}">
                </div>
                <div class="form-group">
                    <label for="tipo" class="form-label">Tipo:</label>
                    <select name="tipo" class="form-control" required>
                        <option value="Cobro" {{ $movimiento->tipo === 'Cobro' ? 'selected' : '' }}>Cobro</option>
                        <option value="Pago" {{ $movimiento->tipo === 'Pago' ? 'selected' : '' }}>Pago</option>
                    </select>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    <a href="{{ route('admin.contabilidad.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
