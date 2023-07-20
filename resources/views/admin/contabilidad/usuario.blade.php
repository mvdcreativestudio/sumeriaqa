@extends('admin.layouts.master')

@section('content')

<section class="section">
  <div class="col-12 m-0 p-0">
    <div class="d-flex col-12">
      <div class="col-6">
        <div class="card author-box card-primary h-100 d-flex flex-column">
          <div class="card-body flex-grow-1">
            <div class="author-box- m-0">
              <div class="author-box-name">
                <a href="#">{{$usuario->nombre}} {{$usuario->apellido}}</a>
              </div>
              <div class="author-box-job">{{$usuario->empresa}}</div>
              <div class="author-box-description">
                <p class="m-0">{{$usuario->direccion}},</p>
                <p class="m-0">{{$usuario->departamento}}, {{$usuario->pais}}</p>
                <p class="m-0">{{$usuario->telefono}}</p>
                <p class="m-0">{{$usuario->email}}</p>
              </div>
              <div class="mb-2 mt-3"><div class="text-small font-weight-bold">Redes Sociales</div></div>
              <a href="#" class="btn btn-social-icon mr-1 btn-facebook">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="btn btn-social-icon mr-1 btn-twitter">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="btn btn-social-icon mr-1 btn-github">
                <i class="fab fa-github"></i>
              </a>
              <a href="#" class="btn btn-social-icon mr-1 btn-instagram">
                <i class="fab fa-instagram"></i>
              </a>
              <div class="w-100 d-sm-none"></div>
            </div>
          </div>
          <div class="p-3 d-flex justify-content-between align-items-center">
            <div>
              <a href="">Estado: <span class="text-success font-weight-bold">Activo</span></a>
            </div>
            <div>
              <a href="#" class="btn btn-transparente mt-auto">Modificar Usuario <i class="fas fa-chevron-right"></i></a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6">
        <div class="card author-box card-primary h-100">
          <div class="card-body">
            <div class="author-box- m-0">
              <div class="author-box-name">
                <a href="#">Movimientos del usuario</a>
              </div>
              <div class="author-box-job">{{$usuario->nombre}} {{$usuario->apellido}}</div>
              <div class="author-box-description">
                <table class="table table-hover">
                  <tbody>
                    <tr class="m-0 p-0">
                      <th scope="row">Pagadas</th>
                      <td>18</td>
                    </tr>
                    <tr>
                      <th scope="row">No Pagadas / Vencidas</th>
                      <td>2</td>
                    </tr>
                    <tr>
                      <th scope="row">Borradores</th>
                      <td colspan="2">1</td>
                    </tr>
                    <tr>
                      <th scope="row">Canceladas</th>
                      <td colspan="2">4</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 mt-1">
      <div class="card-body">
        <div class="row">
          <div class="col-3">
            <h6 class="card-title">Ordenes de pago</h6>
            <ul class="list-group">
              <li class="list-group-item">Crear orden</li>
              <li class="list-group-item">Modificar orden</li>
              <li class="list-group-item">Enviar recordatorio</li>
            </ul>
          </div>
          <div class="col-3">
            <h6 class="card-title">Medios de pago</h6>
            <ul class="list-group">
              <li class="list-group-item">Ingresar tarjetas</li>
              <li class="list-group-item">Adherir a débito automático</li>
              <li class="list-group-item">Ingresar método de reembolso</li>
            </ul>
          </div>
          <div class="col-3">
            <h6 class="card-title">Estado del usuario</h6>
            <ul class="list-group">
              <li class="list-group-item">Estado: <span class="text-success font-weight-bold">Activo</span></li>
              <li class="list-group-item"><span class="text-danger font-weight-bold">Pasar a Inactivo</span></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="col-6 w-100">
        <h6 class="card-title">Correos Electrónicos</h6>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr class="tr-mini">
                <th>Fecha</th>
                <th>Motivo</th>
                <th>Estado</th>
                <th class="text-right">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>10/07/2023</td>
                <td>Orden de pago próximo a vencimiento</td>
                <td>Recibido</td>
                <td>Volver a enviar</td>
              </tr>
              <tr>
                <td>10/07/2023</td>
                <td>Orden de pago próximo a vencimiento</td>
                <td>Recibido</td>
                <td>Volver a enviar</td>
              </tr>
              <tr>
                <td>10/07/2023</td>
                <td>Orden de pago próximo a vencimiento</td>
                <td>Recibido</td>
                <td>Volver a enviar</td>
              </tr>
              <tr>
                <td>10/07/2023</td>
                <td>Orden de pago próximo a vencimiento</td>
                <td>Recibido</td>
                <td>Volver a enviar</td>
              </tr>
              <tr>
                <td>10/07/2023</td>
                <td>Orden de pago próximo a vencimiento</td>
                <td>Recibido</td>
                <td>Volver a enviar</td>
              </tr>
              <tr>
                <td>10/07/2023</td>
                <td>Orden de pago próximo a vencimiento</td>
                <td>Recibido</td>
                <td>Volver a enviar</td>
              </tr>
              

            </tbody>
            <!-- Agrega aquí las filas de la tabla -->
          </table>
        </div>
      </div>
    </div>
      

  </div>
  
</section>

@endsection
