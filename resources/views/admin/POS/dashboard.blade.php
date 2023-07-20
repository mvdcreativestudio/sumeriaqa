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
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1 ">
                            <div class="card-icon bg-primary">
                                <i class="far fa-user"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Ventas hoy</h4>
                                </div>
                                <div class="card-body">
                                    <h4>{{$cantidadPedidosHoy}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1 ">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-money-bill-trend-up"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Ingresos hoy</h4>
                                </div>
                                <div class="card-body">
                                    <h4>${{$ingresosTotalesHoy}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1 ">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-store"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Retiro en local</h4>
                                </div>
                                <div class="card-body">
                                    <h4>{{$cantidadLocalHoy}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1 ">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Entrega a domicilio</h4>
                                </div>
                                <div class="card-body">
                                    <h4>{{$cantidadDomicilioHoy}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row justify-content-center">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1 ">
                            <div class="card-icon bg-primary">
                                <i class="far fa-money-bill-1"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Efectivo</h4>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-text">${{$ingresosEfectivoHoy}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1 ">
                            <div class="card-icon bg-primary">
                                <i class="far fa-credit-card"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Tarjetas</h4>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-text">${{$ingresosTarjetasHoy}}</h4>
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
                                    <h4>Ultimas Ventas</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="table-1">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Forma de entrega</th>
                                                    <th>Medio de pago</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">
                                                @foreach($ordenesHoy as $orden)
                                                <tr>
                                                    <td>{{ $orden->id }}</td>
                                                    <td>{{ $orden->forma_entrega }}</td>
                                                    <td>{{ $orden->medio_pago }}</td>
                                                    <td>${{ $orden->total }}</td>
                                                </tr>
                                            @endforeach
                                          </tbody>                                          
                                        </table>
                                        <div class="justify-content-end d-flex">
                                            <button class="btn btn-primary">Ver todas</button>
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
  
@endsection
