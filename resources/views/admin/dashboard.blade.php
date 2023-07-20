@extends('admin.layouts.master')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Panel de administración</h1>
        </div>
        <div class="card-stats-title pb-4">Estadísticas de pedidos - Hoy</div>

        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="card card-statistic-2 bg-light">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4 class="text-dark">Número de visitantes</h4>
                        </div>
                        <div class="card-body text-dark">
                            2.451
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="card card-statistic-2 bg-light">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-money-bill-alt"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4 class="text-dark">Productos Vendidos</h4>
                        </div>
                        <div class="card-body text-dark">
                            {{$totalProductQty}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="card card-statistic-2 bg-light">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-archive"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4 class="text-dark">Pedidos hoy</h4>
                        </div>
                        <div class="card-body text-dark">
                            {{ $todaysOrder }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="card card-statistic-2 bg-light">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-money-bill-alt"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4 class="text-dark">Ingresos hoy</h4>
                        </div>
                        <div class="card-body text-dark">
                            {{$settings->currency_icon}}{{ $todaysEarnings }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                <div class="card card-statistic-2 bg-light h-100">
                    <div class="card-stats">
                        <div class="card-stats-title bg-light text-center">Resumen</div>
                        <div class="card-stats-items">
                            <div class="card-stats-item text-dark">
                                <div class="card-stats-item-count">
                                    <a class="sinHover text-dark" href="#">{{ $pendientesDePago }}</a>
                                </div>
                                <div class="card-stats-item-label">Pendientes de pago</div>
                            </div>
                            <div class="card-stats-item text-dark">
                                <div class="card-stats-item-count"><a class="sinHover text-dark"
                                        href="#">{{ $ordenesPagas }}</a></div>
                                <div class="card-stats-item-label">Procesando</div>
                            </div>
                            <div class="card-stats-item text-dark">
                                <div class="card-stats-item-count"><a class="sinHover text-dark"
                                        href="#">{{ $totalCompleteOrders }}</a></div>
                                <div class="card-stats-item-label">Entregados</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-wrap text-center pb-2 h-100">
                        <div class="card-header">
                            <h4 class="text-dark">Total de pedidos</h4>
                        </div>
                        <div class="card-body text-dark">
                            {{ $totalOrders }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Estadísticas de venta</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="dailySales" height="70"></canvas>
                            <div class="statistic-details mt-sm-4">
                                <div class="statistic-details-item">
                                    <span class="text-muted">
                                        @if (is_numeric($todaysEarnings) && is_numeric($yesterdayEarnings))
                                            @if ($todaysEarnings > $yesterdayEarnings)
                                                <span class="text-primary">
                                                    <i class="fas fa-caret-up"></i>
                                                </span>
                                                {{$settings->currency_icon}}{{$todaysEarnings - $yesterdayEarnings}}
                                            @elseif ($todaysEarnings < $yesterdayEarnings)
                                                <span class="text-danger">
                                                    <i class="fas fa-caret-down"></i>
                                                </span>
                                                {{$settings->currency_icon}}{{abs($todaysEarnings - $yesterdayEarnings)}}
                                            @else
                                                <span class="text-primary">
                                                    <i class="fas fa-equals"></i>
                                                </span>
                                            @endif
                                        @endif
                                    </span>
                                    <div class="detail-value">{{$settings->currency_icon}}{{ $todaysEarnings }}</div>
                                    <div class="detail-name">Ventas de hoy</div>
                                </div>

                                <div class="statistic-details-item">
                                    <span class="text-muted">
                                        @if (is_numeric($weekEarnings) && is_numeric($lastWeekEarnings))
                                            @if ($weekEarnings > $lastWeekEarnings)
                                                <span class="text-primary">
                                                    <i class="fas fa-caret-up"></i>
                                                </span>
                                                {{$settings->currency_icon}}{{$weekEarnings - $lastWeekEarnings}}
                                            @elseif ($weekEarnings < $lastWeekEarnings)
                                                <span class="text-danger">
                                                    <i class="fas fa-caret-down"></i>
                                                </span>
                                                {{$settings->currency_icon}}{{abs($weekEarnings - $lastWeekEarnings)}}
                                            @else
                                                <span class="text-primary">
                                                    <i class="fas fa-equals"></i>
                                                </span>
                                            @endif
                                        @endif
                                    </span>
                                    <div class="detail-value">{{$settings->currency_icon}}{{$weekEarnings}}</div>
                                    <div class="detail-name">Ventas de esta semana</div>
                                </div>
                                <div class="statistic-details-item">
                                    <span class="text-muted">
                                        @if (is_numeric($monthEarnings) && is_numeric($lastMonthEarnings))
                                            @if ($monthEarnings > $lastMonthEarnings)
                                                <span class="text-primary">
                                                    <i class="fas fa-caret-up"></i>
                                                </span>
                                                {{$settings->currency_icon}}{{$monthEarnings - $lastMonthEarnings}}
                                            @elseif ($monthEarnings < $lastMonthEarnings)
                                                <span class="text-danger">
                                                    <i class="fas fa-caret-down"></i>
                                                </span>
                                                {{$settings->currency_icon}}{{abs($monthEarnings - $lastMonthEarnings)}}
                                            @else
                                                <span class="text-primary">
                                                    <i class="fas fa-equals"></i>
                                                </span>
                                            @endif
                                        @endif
                                    </span>
                                    <div class="detail-value">{{$settings->currency_icon}}{{$monthEarnings}}</div>
                                    <div class="detail-name">Ventas este mes</div>
                                </div>
                                <div class="statistic-details-item">
                                    <span class="text-muted">
                                        @if (is_numeric($yearEarnings) && is_numeric($lastYearEarnings))
                                            @if ($yearEarnings > $lastYearEarnings)
                                                <span class="text-primary">
                                                    <i class="fas fa-caret-up"></i>
                                                </span>
                                                {{$settings->currency_icon}}{{$yearEarnings - $lastYearEarnings}}
                                            @elseif ($yearEarnings < $lastYearEarnings)
                                                <span class="text-danger">
                                                    <i class="fas fa-caret-down"></i>
                                                </span>
                                                {{$settings->currency_icon}}{{abs($yearEarnings - $lastYearEarnings)}}
                                            @else
                                                <span class="text-primary">
                                                    <i class="fas fa-equals"></i>
                                                </span>
                                            @endif
                                        @endif
                                    </span>
                                    <div class="detail-value">{{$settings->currency_icon}}{{$yearEarnings}}</div>
                                    <div class="detail-name">Ventas este año</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <h6>Estadísticas de la tienda</h6>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="summary">
                            <div class="summary-item">
                                <h6>Productos más vendidos</h6>
                                <ul class="list-unstyled list-unstyled-border">
                                    <li class="media">
                                        <a href="#">
                                            <img class="mr-3 rounded" width="50"
                                                src="/uploads/media_6446aaa52cdd9.jpg" alt="product">
                                        </a>
                                        <div class="media-body">
                                            <div class="media-right">51 Vendidos</div>
                                            <div class="media-title"><a href="#">Canon EOS Rebel SL3</a></div>
                                            <div class="text-small">Cámaras Digitales</div>
                                            <div class="text-muted text-small">Precio: $490</div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <a href="#">
                                            <img class="mr-3 rounded" width="50"
                                                src="/uploads/media_6446bff6ec3ba.jpg" alt="product">
                                        </a>
                                        <div class="media-body">
                                            <div class="media-right">25 Vendidos</div>
                                            <div class="media-title"><a href="#">GoPro Hero 4</a></div>
                                            <div class="text-small">Cámaras Digitales</div>
                                            <div class="text-muted text-small">Precio: $290</div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <a href="#">
                                            <img class="mr-3 rounded" width="50"
                                                src="/uploads/media_64479c87a3122.jpg" alt="product">
                                        </a>
                                        <div class="media-body">
                                            <div class="media-right">15 Vendidos</div>
                                            <div class="media-title"><a href="#">Laptop ROG Strix 17"</a></div>
                                            <div class="text-small">Laptops & Computadoras</div>
                                            <div class="text-muted text-small">Precio: $1490</div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="summary">
                            <div class="summary-item">
                                <h6>Mejores compradores</h6>
                                <ul class="list-unstyled list-unstyled-border">
                                    <li class="media">
                                        <a href="#">
                                            <img class="mr-3 rounded" width="50"
                                                src="/uploads/1577513059_T05FAH35R0T-U05FD4RHD44-781e8d2dd092-512.jpg"
                                                alt="product">
                                        </a>
                                        <div class="media-body">
                                            <div class="media-right">$48.751</div>
                                            <div class="media-title"><a href="#">Martín Santamaría</a></div>
                                            <div class="text-small">Ciudad de la Costa</div>
                                            <div class="text-muted text-small">Ticket promedio: $1980</div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <a href="#">
                                            <img class="mr-3 rounded" width="50"
                                                src="/uploads/1782594359_profile-pic(13)(1).png" alt="product">
                                        </a>
                                        <div class="media-body">
                                            <div class="media-right">$37.311</div>
                                            <div class="media-title"><a href="#">Gastón Dotta</a></div>
                                            <div class="text-small">Buenos Aires</div>
                                            <div class="text-muted text-small">Ticket promedio: $1280</div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <a href="#">
                                            <img class="mr-3 rounded" width="50"
                                                src="/uploads/2138622900_profile-pic(21)(1).png" alt="product">
                                        </a>
                                        <div class="media-body">
                                            <div class="media-right">$17.652</div>
                                            <div class="media-title"><a href="#">Mikaela Santamaría</a></div>
                                            <div class="text-small">Montevideo</div>
                                            <div class="text-muted text-small">Ticket promedio: $1145</div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>      
</section>
@endsection





@push('scripts')

<script>
    const ctx = document.getElementById('dailySales').getContext('2d');
    const salesData = {!! json_encode($salesData) !!};

    const dailySalesChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['{{ Carbon\Carbon::today()->subDays(6)->format('j/n') }}', '{{ Carbon\Carbon::today()->subDays(5)->format('j/n') }}', '{{ Carbon\Carbon::today()->subDays(4)->format('j/n') }}', '{{ Carbon\Carbon::today()->subDays(3)->format('j/n') }}', '{{ Carbon\Carbon::today()->subDays(2)->format('j/n') }}', '{{ Carbon\Carbon::yesterday()->format('j/n') }}', '{{ Carbon\Carbon::today()->format('j/n') }}'],
        datasets: [{
            label: 'Ventas por día',
            data: Object.values(salesData),
            borderWidth: 2,
            borderColor: 'rgba(39, 41, 61, 1)',
            backgroundColor: 'rgba(39, 41, 61, 1)'
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function (value, index, values) {
                        return '$' + value.toLocaleString();
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function (context) {
                        let label = context.dataset.label || '';
                        if (label) {
                            label += ': ';
                        }
                        label += '$' + context.parsed.y.toLocaleString();
                        return label;
                    }
                }
            }
        }
    }
});
</script>
@endpush
