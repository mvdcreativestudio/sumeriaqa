@extends('admin.layouts.master')

@section('content')
      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Reglas de envío</h1>
          </div>

          <div class="section-body">

            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Crear regla de envío</h4>

                  </div>
                  <div class="card-body">
                    <form action="{{route('admin.shipping-rule.store')}}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="name" value="">
                        </div>

                        <div class="form-group">
                            <label for="inputState">Tipo</label>
                            <select id="" class="form-control shipping-type" name="type">
                              <option value="flat_cost">Costo fijo</option>
                              <option value="min_cost">Monto mínimo</option>
                            </select>
                        </div>

                        <div class="form-group min_cost d-none">
                            <label>Monto mínimo</label>
                            <input type="text" class="form-control" name="min_cost" value="">
                        </div>

                        <div class="form-group">
                            <label>Costo</label>
                            <input type="text" class="form-control" name="cost" value="">
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

@push('scripts')
<script>
    $(document).ready(function(){
        $('body').on('change', '.shipping-type', function(){
            let value = $(this).val();

            if(value != 'min_cost'){
                $('.min_cost').addClass('d-none')
            }else {
                $('.min_cost').removeClass('d-none')
            }
        })
    })
</script>
@endpush
