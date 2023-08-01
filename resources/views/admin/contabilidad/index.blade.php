@extends('admin.layouts.master')

@section('content')
    <div id="app">
        <!-- Main Content -->
        <div class="">
            <section class="section">
                <div class="section-header d-flex justify-content-between align-items-center">
                    <h1 class="mr-auto">Dashboard</h1>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1 ">
                            <div class="card-icon">
                                <i class="far fa-user"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Clientes</h4>
                                </div>
                                <div class="card-body">
                                    {{$clienteCount}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1 ">
                            <div class="card-icon">
                                <i class="far fa-user"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Proveedores</h4>
                                </div>
                                <div class="card-body">
                                    {{$proveedoresCount}}
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1 ">
                            <div class="card-icon">
                                <i class="fas fa-arrows-spin"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Movimientos</h4>
                                </div>
                                <div class="card-body">
                                    {{ $totalTransacciones}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row mb-5">
                    <div class="col-6 h-100">
                        <h6>Facturas a cobrar</h6>
                        <div class="card h-100">
                            <div class="row d-flex">
                                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="card card-statistic-1">
                                        <div class="card-icon bg-success">
                                            <i class="far fa-file"></i>
                                        </div>
                                        <div class="card-wrap">
                                            <div class="card-header">
                                                <h4>Vigentes</h4>
                                            </div>
                                            <div class="card-body">
                                                {{ $contabilidadVigentes }}
                                            </div>
                                            <div>
                                                <a href="">{{$settings->currency_icon}}{{ $montoVigentes }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="card card-statistic-1">
                                        <div class="card-icon bg-warning">
                                            <i class="far fa-file"></i>
                                        </div>
                                        <div class="card-wrap">
                                            <div class="card-header">
                                                <h4>Por Vencer</h4>
                                            </div>
                                            <div class="card-body">
                                                {{ $contabilidadPorVencer }}
                                            </div>
                                            <div>
                                                <a href="">{{$settings->currency_icon}}{{ $montoPorVencer }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="card card-statistic-1">
                                        <div class="card-icon bg-danger">
                                            <i class="far fa-file"></i>
                                        </div>
                                        <div class="card-wrap">
                                            <div class="card-header">
                                                <h4>Vencidas</h4>
                                            </div>
                                            <div class="card-body">
                                                {{ $contabilidadVencidos }}
                                            </div>
                                            <div>
                                                <a href="">{{$settings->currency_icon}}{{ $montoVencidos }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-6 h-100">
                        <h6>Facturas a pagar</h6>
                        <div class="card h-100">
                            <div class="row  d-flex align-items-center">
                                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="card card-statistic-1">
                                        <div class="card-icon bg-success">
                                            <i class="far fa-file"></i>
                                        </div>
                                        <div class="card-wrap">
                                            <div class="card-header">
                                                <h4>Vigentes</h4>
                                            </div>
                                            <div class="card-body">
                                                {{ $contabilidadVigentes }}
                                            </div>
                                            <div>
                                                <a href="">{{$settings->currency_icon}}{{ $montoVigentes }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="card card-statistic-1">
                                        <div class="card-icon bg-warning">
                                            <i class="far fa-file"></i>
                                        </div>
                                        <div class="card-wrap">
                                            <div class="card-header">
                                                <h4>Por Vencer</h4>
                                            </div>
                                            <div class="card-body">
                                                {{ $contabilidadPorVencer }}
                                            </div>
                                            <div>
                                                <a href="">{{$settings->currency_icon}}{{ $montoPorVencer }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="card card-statistic-1">
                                        <div class="card-icon bg-danger">
                                            <i class="far fa-file"></i>
                                        </div>
                                        <div class="card-wrap">
                                            <div class="card-header">
                                                <h4>Vencidas</h4>
                                            </div>
                                            <div class="card-body">
                                                {{ $contabilidadVencidos }}
                                            </div>
                                            <div>
                                                <a href="">{{$settings->currency_icon}}{{ $montoVencidos }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                
                

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Estadísticas</h4>
                            </div>
                            <div class="card-body">
    
                                <canvas id="chartContainer" style="height: 400px; width: 100%;"></canvas>
                                
                                <div class="statistic-details mt-sm-4">
                                    <div class="statistic-details-item">
                                        <div class="detail-value">{{$settings->currency_icon}}{{ $cobradoHoy }}</div>
                                        <div class="detail-name">Ingresos hoy</div>
                                    </div>
                                    <div class="statistic-details-item">
                                        <div class="detail-value">{{$settings->currency_icon}}{{ $ingresosSemana }}</div>
                                        <div class="detail-name">Ingresos esta semana</div>
                                    </div>
                                    <div class="statistic-details-item">
                                        <div class="detail-value">{{$settings->currency_icon}}{{ $ingresosMes }}</div>
                                        <div class="detail-name">Ingresos este mes</div>
                                    </div>
                                    <div class="statistic-details-item">
                                        <div class="detail-value">{{$settings->currency_icon}}{{ $ingresosAño }}</div>
                                        <div class="detail-name">Ingresos este año</div>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Últimos movimientos</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="table-1">
                                                <thead class="text-center thead-dark">
                                                    <tr class="tr-light text-white">
                                                        <th>#</th>
                                                        <th>Cliente</th>
                                                        <th>Empresa</th>
                                                        <th>Concepto</th>
                                                        <th>Monto</th>
                                                        <th>Tipo</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    @php
                                                        $movimientos = $contabilidad->where('estado', 'Pago')->sortBy('fecha_de_pago')->take(10);
                                                    @endphp
                                                    @foreach ($movimientos as $movimiento)
                                                        <tr>
                                                            <td>
                                                                <a class="text-dark" href="{{ route('contabilidad.ver', $movimiento->id) }}">{{ $movimiento->id }}</a>
                                                            </td>
                                                            <td>
                                                                <a class="text-dark" href="{{ route('contabilidad.ver', $movimiento->id) }}">{{ $movimiento->nombre_cliente }}</a>
                                                            </td>
                                                            <td>
                                                                @if ($movimiento->usuario)
                                                                    <a class="text-dark" href="{{ route('contabilidad.ver', $movimiento->id) }}">{{ $movimiento->usuario->empresa }}</a>
                                                                @elseif ($movimiento->usuario_id === null)
                                                                    {{ $movimiento->empresa }}
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td class="text-dark">{{ $movimiento->concepto }}</td>
                                                            <td class="text-dark">${{ $movimiento->monto }}</td>
                                                            <td>
                                                                @if ($movimiento->tipo === 'Cobro')
                                                                    <span class="text-success font-weight-bold">Ingreso</span>
                                                                @else
                                                                    <span class="text-danger font-weight-bold">Egreso</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>                                             
                                            </table>
                                        </div>

                                    </div>
                                    <div class="card-header-action text-right">
                                        <a href=" {{ route('admin.contabilidad.transactions') }} " class="btn btn-primary">Ver todos</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

  
@endsection

@push('scripts')
    <script>
        $('.btn-edit').click(function() {
            var movimientoId = $(this).data('id');
            var editarMovimientoUrl = "{{ route('contabilidad.editar', ':id') }}";
            editarMovimientoUrl = editarMovimientoUrl.replace(':id', movimientoId);
            $('#editarMovimientoForm').attr('action', editarMovimientoUrl);
            $('#editarMovimientoModal').modal('show');
        });
    </script>


<!-- Gráfica 10 días -->
<script>
    // Obtiene los datos del gráfico del controlador de Laravel
    fetch('/contabilidad/chart-data')
        .then(response => response.json())
        .then(data => {
            // Crea el gráfico con los datos obtenidos
            const chart = new Chart(document.getElementById('chartContainer'), {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'day'
                            }
                        },
                        y: {
                            ticks: {
                                // Utilizamos la función callback para formatear los valores del eje Y con el símbolo "$"
                                callback: function (value, index, values) {
                                    // Verificamos si el valor es negativo
                                    if (value < 0) {
                                        return '-{{$settings->currency_icon}}' + Math.abs(value).toFixed(0);
                                    } else {
                                        return '{{$settings->currency_icon}}' + value.toFixed(0);
                                    }
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                title: function (context) {
                                    return ''; // Para eliminar la fecha del tooltip
                                },
                                label: function (context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    // Verificamos si el valor es negativo en el tooltip
                                    if (context.parsed.y < 0) {
                                        label += '-{{$settings->currency_icon}}' + Math.abs(context.parsed.y).toFixed(0);
                                    } else {
                                        label += '{{$settings->currency_icon}}' + context.parsed.y.toFixed(0);
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        });
</script>

@endpush




