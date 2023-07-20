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



                <div class="row">
    
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1 ">
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
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1 ">
                            <div class="card-icon bg-warning">
                                <i class="far fa-file"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Por vencer</h4>
                                </div>
                                <div class="card-body">
                                    {{ $contabilidadPorVencer }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1 ">
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
                        <canvas id="myChart" height="182"></canvas>
                        <div class="statistic-details mt-sm-4">
                          <div class="statistic-details-item">
                            <div class="detail-value">${{$cobradoHoy}}</div>
                            <div class="detail-name">Ingresos hoy</div>
                          </div>
                          <div class="statistic-details-item">
                            <div class="detail-value">${{$ingresosSemana}}</div>
                            <div class="detail-name">Ingresos esta semana</div>
                          </div>
                          <div class="statistic-details-item">
                            <div class="detail-value">${{$ingresosMes}}</div>
                            <div class="detail-name">Ingresos este mes</div>
                          </div>
                          <div class="statistic-details-item">
                            <div class="detail-value">${{$ingresosAño}}</div>
                            <div class="detail-name">Ingresos este año</div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Últimos contabilidad</h4>
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
                                                        <th class="text-right">Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    @foreach ($contabilidad->take(10) as $movimiento)
                                                    <tr>
                                                        <td><a class="text-dark" href="{{ route('contabilidad.ver', $movimiento->id) }}">{{ $movimiento->id }}</a></td>
                                                        <td><a class="text-dark" href="{{ route('contabilidad.ver', $movimiento->id) }}">{{ $movimiento->nombre_cliente }}</a></td>
                                                        <td><a class="text-dark" href="{{ route('contabilidad.ver', $movimiento->id) }}">{{ $movimiento->usuario->empresa ?: '-' }}</a></td>
                                                        <td class="text-dark">{{ $movimiento->concepto }}</td>
                                                        <td class="text-dark">${{ $movimiento->monto }}</td>
                                                        <td>
                                                            @if ($movimiento->tipo === 'Cobro')
                                                            <span class="text-success font-weight-bold">Ingreso</span>
                                                            @else
                                                            <span class="text-danger font-weight-bold">Egreso</span>
                                                            @endif
                                                        </td>
                                                        <td class="col-2 text-right">
                                                            <a href="{{ route('contabilidad.ver', $movimiento->id) }}" class="btn btn-primary btn-action btn-detail"
                                                                data-toggle="tooltip" title="Ver">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>


    <script>
      $('.btn-edit').click(function() {
          var movimientoId = $(this).data('id');
          var editarMovimientoUrl = "{{ route('contabilidad.editar', ':id') }}";
          editarMovimientoUrl = editarMovimientoUrl.replace(':id', movimientoId);
          $('#editarMovimientoForm').attr('action', editarMovimientoUrl);
          $('#editarMovimientoModal').modal('show');
      });
  </script>
  
@endsection
