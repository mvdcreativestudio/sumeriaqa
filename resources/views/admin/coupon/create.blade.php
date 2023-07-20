@extends('admin.layouts.master')

@section('content')
      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Cupón</h1>
          </div>

          <div class="section-body">

            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Crear cupón</h4>

                  </div>
                  <div class="card-body">
                    <form action="{{route('admin.coupons.store')}}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="name" value="">
                        </div>

                        <div class="form-group">
                            <label>Código</label>
                            <input type="text" class="form-control" name="code" value="">
                        </div>


                        <div class="form-group">
                            <label>Cantidad</label>
                            <input type="text" class="form-control" name="quantity" value="">
                        </div>

                        <div class="form-group">
                            <label>Usos máximos por persona</label>
                            <input type="text" class="form-control" name="max_use" value="">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha de inicio</label>
                                        <input type="text" class="form-control datepicker" name="start_date" value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha de finalización</label>
                                    <input type="text" class="form-control datepicker" name="end_date" value="">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="inputState">Tipo de descuento</label>
                                    <select id="inputState" class="form-control sub-category" name="discount_type">
                                      <option value="percent">Porcentaje (%)</option>
                                      <option value="amount">Monto ({{$settings->currency_icon}})</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Valor del descuento</label>
                                    <input type="text" class="form-control" name="discount" value="">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputState">Estado</label>
                            <select id="inputState" class="form-control" name="status">
                              <option value="1">Activo</option>
                              <option value="0">Inactivo</option>
                            </select>
                        </div>
                        <button type="submmit" class="btn btn-primary">Crear</button>
                    </form>
                  </div>

                </div>
              </div>
            </div>

          </div>
        </section>

@endsection
