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
                                    <h4>Empleados</h4>
                                </div>
                                <div class="card-body">
                                    <h4>24</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1 ">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-umbrella-beach"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>En Vacaciones</h4>
                                </div>
                                <div class="card-body">
                                    <h4>2</h4>
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
                                    <h4> 3 </h4>
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
                                    <h4> 4 </h4>
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
                                    <h4 class="card-text"> 5 </h4>
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
                                    <h4 class="card-text"> 6 </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>

  
@endsection
